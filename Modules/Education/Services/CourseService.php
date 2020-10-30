<?php

namespace Modules\Education\Services;

use Illuminate\Support\Facades\DB;
use Modules\Education\Entities\Course;
use Modules\Education\Repository\CourseRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CourseService
{

    /**
     * Course Repository
     *
     * @var CourseRepository
     */
    private $repository;

    /**
     * Course Repository
     * @param CourseRepository
     *
     * @return this
     */
    public function __construct(CourseRepository $repository)
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
        $course = $this->find($id);

        return $this->repository->delete($course);
    }

    /**
     * Find a model by its primary key
     * @param int $id
     * @return Course
     *
     * @throws ModelNotFoundException
     */
    public function find(int $id)
    {
        $course = $this->repository->find($id);

        if(empty($course)) {
            throw (new ModelNotFoundException)->setModel(
                get_class(Course::class), $id
            );
        }

        return $course;
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
     * Create Course
     * @param string $name
     *
     * @return Boolean|Course
     */
    public function create(
		string $name,
		string $description
    ) {

        $course = new Course();
        
		$course->name = $name;
		$course->description = $description;

        DB::beginTransaction();

        $isOk = $this->repository->save($course);

        if ($isOk) {
            DB::commit();
            return $course;
        } else {
            DB::rollBack();
            return $isOk;
        }
    }

    /**
     * Update Course
     *
     * @param int $id
     * @param string $name
     *
     * @return boolean
     */
    public function update(
        int $id,
		string $name,
		string $description
    ) {

        $course = $this->repository->find($id);
        $course->id = $id;
		$course->name = $name;
		$course->description = $description;

        DB::beginTransaction();

        $isOk = $this->repository->save($course);

        if ($isOk) {
            DB::commit();
        } else {
            DB::rollBack();
        }

        return $isOk;
    }
}
