<?php

namespace Modules\Education\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\CmsController;

use Modules\Education\Services\EnrollmentService;
use Modules\Education\Http\Requests\Enrollment\EnrollmentStoreRequest;
use Modules\Education\Http\Requests\Enrollment\EnrollmentUpdateRequest;

/**
 * Class EnrollmentController
 * @package App\Http\Controllers
 */
class EnrollmentController extends CmsController
{
    /**
     * Path to views
     */
    protected $_path = 'education::enrollment.';

    /**
     * Action Index in controller
     */
    protected $_actionIndex = '\Modules\Education\Http\Controllers\EnrollmentController@index';

    /**
     * Modules\Education\Services\EnrollmentService
     *
     * @var Modules\Education\Services\EnrollmentService
     */
    private $service;

    function __construct(EnrollmentService $service)
    {
        $this->service = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (empty($request->q)) {
            $enrollments = $this->service->paginate();
        } else {
            $enrollments = $this->search($request);
        }

        return $this->showView(__FUNCTION__, compact('enrollments'));
    }

    /**
     * Para pesquisa
     * @param Request $request
     */
    public function search(Request $request)
    {
        if ($request->has('q')) {
            $search = [];
            $search['stundant.name'] = $request->q;
            $search['team.course.name'] = $request->q;

            return $this->service
                        ->search(10, $search);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->showView('create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(EnrollmentStoreRequest $request)
    {
        $enrollment = $this->service->create(
				$request->active,
				$request->team_id,
				$request->student_id
                    );

        if (empty($enrollment)) {
            return $this->returnIndexStatusNotOk(__('Something went wrong and the record was not saved'));
        }

        return $this->returnIndexStatusOk($enrollment->name . __(' created'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {

            $enrollment = $this->service->find($id);

        } catch (\Throwable $th) {

            return $this->returnIndexStatusNotOk(__('Record not found'));

        }

        return $this->showView(__FUNCTION__, compact('enrollment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(EnrollmentUpdateRequest $request, $id)
    {
        try {

            if ($this->service->update(
                    $id,
                    $request->active,
                    $request->team_id
                )
            )
                return $this->returnIndexStatusOk(__('Updated'));

        } catch (\Throwable $th) {

            if($th instanceof ModelNotFoundException)
                $error = __('Record not found');
        }

        return $this->returnIndexStatusNotOk($error ?? 'Record has not been updated');
    }

    /**
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($id)
    {
       try {

            if ($this->service->delete($id)) {
                return $this->returnIndexStatusOk(__('Deleted'));
            }

        } catch (\Throwable $th) {

            if($th instanceof QueryException && Str::is('*Integrity constraint violation*',$th->getMessage()))
                $error = 'It cannot be deleted, it is in use in another record.';

            if($th instanceof ModelNotFoundException)
                $error = __('Record not found');
        }

        return $this->returnIndexStatusNotOk($error ?? "Something went wrong and the record was not deleted");
    }
}
