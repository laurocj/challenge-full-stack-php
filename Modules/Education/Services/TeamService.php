<?php

namespace Modules\Education\Services;

use Illuminate\Support\Facades\DB;
use Modules\Education\Entities\Team;
use Modules\Education\Repository\TeamRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TeamService
{

    /**
     * Team Repository
     *
     * @var TeamRepository
     */
    private $repository;

    /**
     * Team Repository
     * @param TeamRepository
     *
     * @return this
     */
    public function __construct(TeamRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Delete a model by its primary key
     * @param int $id
     * @return boolean
     *
     * @throws ModelNotFoundException|QueryException
     */
    public function delete(int $id)
    {
        $team = $this->find($id);

        return $this->repository->delete($team);
    }

    /**
     * Find a model by its primary key
     * @param int $id
     * @return Team
     *
     * @throws ModelNotFoundException
     */
    public function find(int $id)
    {
        $team = $this->repository->find($id);

        if(empty($team)) {
            throw (new ModelNotFoundException)->setModel(
                get_class(Team::class), $id
            );
        }

        return $team;
    }

    /**
     * @param int $itensPerPages
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(?int $courseId, int $itensPerPages = 10)
    {
        $search = is_numeric($courseId) ? ['course_id' => $courseId] : [];
        return $this->repository->search($itensPerPages, $search);
    }

    /**
     * @param int $itensPerPages
     * @param array $search
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function search(int $itensPerPages = 10, array $search)
    {
        return $this->repository->search($itensPerPages,$search);
    }

    /**
     * Create Team
	 * @param bool $active
	 * @param string $name
	 * @param string $shift
	 * @param string $start_date
	 * @param string $end_date
	 * @param int $course_id
     *
     * @return Boolean|Team
     */
    public function create(
		?bool $active,
		string $name,
		string $shift,
		string $start_date,
		string $end_date,
		int $course_id
    ) {

        $team = new Team();

		$team->active = isset($active) ? $active : false;
		$team->name = $name;
		$team->shift = $shift;
		$team->start_date = $start_date;
		$team->end_date = $end_date;
		$team->course_id = $course_id;

        DB::beginTransaction();

        $isOk = $this->repository->save($team);

        if ($isOk) {
            DB::commit();
            return $team;
        } else {
            DB::rollBack();
            return $isOk;
        }
    }

    /**
     * Update Team
     *
     * @param int $id
	 * @param bool $active
	 * @param string $name
	 * @param string $shift
	 * @param string $start_date
	 * @param string $end_date
	 * @param int $course_id
     *
     * @return boolean
     */
    public function update(
        int $id,
		bool $active,
		string $name,
		string $shift,
		string $start_date,
		string $end_date,
		int $course_id
    ) {

        $team = $this->repository->find($id);
        $team->id = $id;
		$team->active = isset($active) ? $active : false;
		$team->name = $name;
		$team->shift = $shift;
		$team->start_date = $start_date;
		$team->end_date = $end_date;
		$team->course_id = $course_id;

        DB::beginTransaction();

        $isOk = $this->repository->save($team);

        if ($isOk) {
            DB::commit();
        } else {
            DB::rollBack();
        }

        return $isOk;
    }
}
