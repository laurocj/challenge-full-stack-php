<?php

namespace Modules\Education\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\CmsController;

use Modules\Education\Services\TeamService;
use Modules\Education\Http\Requests\Team\TeamStoreRequest;
use Modules\Education\Http\Requests\Team\TeamUpdateRequest;
use Modules\Education\Services\CourseService;

/**
 * Class TeamController
 * @package App\Http\Controllers
 */
class TeamController extends CmsController
{
    /**
     * Path to views
     */
    protected $_path = 'education::team.';

    /**
     * Action Index in controller
     */
    protected $_actionIndex = '\Modules\Education\Http\Controllers\TeamController@index';

    /**
     * Modules\Education\Services\TeamService
     *
     * @var Modules\Education\Services\TeamService
     */
    private $service;

    function __construct(TeamService $service)
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
            $teams = $this->service->paginate($request->course_id);
        } else {
            $teams = $this->search($request);
        }

        return $this->showView(__FUNCTION__, compact('teams'));
    }

    /**
     * Para pesquisa
     * @param Request $request
     */
    public function search(Request $request)
    {
        if ($request->has('q')) {
            $search = [];
            $search['name'] = $request->q;
            $search['course.name'] = $request->q;

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
    public function store(TeamStoreRequest $request)
    {
        $team = $this->service->create(
				$request->active,
				$request->name,
				$request->shift,
				$request->start_date,
				$request->end_date,
				$request->course_id
                    );

        if (empty($team)) {
            return $this->returnIndexStatusNotOk(__('Something went wrong and the record was not saved'));
        }

        return $this->returnIndexStatusOk($team->name . __(' created'));
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

            $team = $this->service->find($id);

        } catch (\Throwable $th) {

            return $this->returnIndexStatusNotOk(__('Record not found'));

        }

        return $this->showView(__FUNCTION__, compact('team'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(TeamUpdateRequest $request, $id)
    {
        try {

            if ($this->service->update(
                    $id,
				$request->active,
				$request->name,
				$request->shift,
				$request->start_date,
				$request->end_date,
				$request->course_id
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
