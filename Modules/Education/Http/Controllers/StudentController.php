<?php

namespace Modules\Education\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\CmsController;

use Modules\Education\Services\StudentService;
use Modules\Education\Http\Requests\Student\StudentStoreRequest;
use Modules\Education\Http\Requests\Student\StudentUpdateRequest;

/**
 * Class StudentController
 * @package App\Http\Controllers
 */
class StudentController extends CmsController
{
    /**
     * Path to views
     */
    protected $_path = 'education::student.';

    /**
     * Action Index in controller
     */
    protected $_actionIndex = '\Modules\Education\Http\Controllers\StudentController@index';

    /**
     * Modules\Education\Services\StudentService
     *
     * @var Modules\Education\Services\StudentService
     */
    private $service;

    function __construct(StudentService $service)
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
            $students = $this->service->paginate();
        } else {
            $students = $this->search($request);
        }

        return $this->showView(__FUNCTION__, compact('students'));
    }

    /**
     * For search
     * @param Request $request
     */
    public function search(Request $request)
    {
        if ($request->has('q')) {
            return $this->service->search(10, ['name' => $request->q]);
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
    public function store(StudentStoreRequest $request)
    {
        $student = $this->service->create(
                        $request->name,
                        $request->email,
                        $request->academic_record,
                        $request->cpf
                    );

        if (empty($student)) {
            return $this->returnIndexStatusNotOk(__('Something went wrong and the record was not saved'));
        }

        return $this->returnIndexStatusOk($student->name . ' created');
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

            $student = $this->service->find($id);

        } catch (\Throwable $th) {

            return $this->returnIndexStatusNotOk(__('Record not found'));

        }

        return $this->showView(__FUNCTION__, compact('student'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StudentUpdateRequest $request, $id)
    {
        try {

            if ($this->service->update(
                    $id,
                    $request->name,
                    $request->email,
                    $request->cpf
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
