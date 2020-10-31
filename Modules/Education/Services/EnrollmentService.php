<?php

namespace Modules\Education\Services;

use Illuminate\Support\Facades\DB;
use Modules\Education\Entities\Enrollment;
use Modules\Education\Repository\EnrollmentRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EnrollmentService
{

    /**
     * Enrollment Repository
     *
     * @var EnrollmentRepository
     */
    private $repository;

    /**
     * Enrollment Repository
     * @param EnrollmentRepository
     *
     * @return this
     */
    public function __construct(EnrollmentRepository $repository)
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
        $enrollment = $this->find($id);

        return $this->repository->delete($enrollment);
    }

    /**
     * Find a model by its primary key
     * @param int $id
     * @return Enrollment
     *
     * @throws ModelNotFoundException
     */
    public function find(int $id)
    {
        $enrollment = $this->repository->find($id);

        if(empty($enrollment)) {
            throw (new ModelNotFoundException)->setModel(
                get_class(Enrollment::class), $id
            );
        }

        return $enrollment;
    }

    /**
     * @param int $itensPerPages
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function paginate(int $itensPerPages = 10)
    {
        return $this->repository->paginate($itensPerPages);
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
     * Create Enrollment
	 * @param bool $active
	 * @param int $team_id
	 * @param int $student_id
     *
     * @return Boolean|Enrollment
     */
    public function create(
		?bool $active,
		int $team_id,
		int $student_id
    ) {

        $enrollment = new Enrollment();

		$enrollment->active = isset($active) ? $active : false;
		$enrollment->date = date('Y-m-d H:i:s');
		$enrollment->team_id = $team_id;
		$enrollment->student_id = $student_id;

        DB::beginTransaction();

        $isOk = $this->repository->save($enrollment);

        if ($isOk) {
            DB::commit();
            return $enrollment;
        } else {
            DB::rollBack();
            return $isOk;
        }
    }

    /**
     * Update Enrollment
     *
     * @param int $id
	 * @param int $team_id
     *
     * @return boolean
     */
    public function update(
        int $id,
		int $team_id
    ) {

        $enrollment = $this->repository->find($id);
		$enrollment->team_id = $team_id;

        DB::beginTransaction();

        $isOk = $this->repository->save($enrollment);

        if ($isOk) {
            DB::commit();
        } else {
            DB::rollBack();
        }

        return $isOk;
    }
}
