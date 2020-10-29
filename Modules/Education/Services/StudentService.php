<?php

namespace Modules\Education\Services;

use Illuminate\Support\Facades\DB;
use Modules\Education\Entities\Student;
use Modules\Education\Repository\StudentRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class StudentService
{

    /**
     * Student Repository
     *
     * @var StudentRepository
     */
    private $repository;

    /**
     * Student Repository
     * @param StudentRepository
     *
     * @return this
     */
    public function __construct(StudentRepository $repository)
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
        $student = $this->find($id);

        return $this->repository->delete($student);
    }

    /**
     * Find a model by its primary key
     * @param int $id
     * @return Student
     *
     * @throws ModelNotFoundException
     */
    public function find(int $id)
    {
        $student = $this->repository->find($id);

        if(empty($student)) {
            throw (new ModelNotFoundException)->setModel(
                get_class(Student::class), $id
            );
        }

        return $student;
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
    public function search(int $itensPerPages, array $search)
    {
        return $this->repository->search($itensPerPages,$search);
    }

    /**
     * Create Student
     * @param string $name
	 * @param string $email
	 * @param string $academic_record
	 * @param string $cpf
     *
     * @return Boolean|Student
     */
    public function create(
		string $name,
        string $email,
        string $academic_record,
		string $cpf
    ) {

        $student = new Student();

		$student->name = $name;
        $student->email = $email;
        $student->academic_record = $academic_record;
		$student->cpf = $cpf;

        DB::beginTransaction();

        $isOk = $this->repository->save($student);

        if ($isOk) {
            DB::commit();
            return $student;
        } else {
            DB::rollBack();
            return $isOk;
        }
    }

    /**
     * Update Student
     *
     * @param int $id
     * @param string $name
     * @param string $email
	 * @param string $cpf
     *
     * @return boolean
     */
    public function update(
        int $id,
		string $name,
		string $email,
		string $cpf
    ) {

        $student = $this->repository->find($id);
        $student->id = $id;
		$student->name = $name;
		$student->email = $email;
		$student->cpf = $cpf;

        DB::beginTransaction();

        $isOk = $this->repository->save($student);

        if ($isOk) {
            DB::commit();
        } else {
            DB::rollBack();
        }

        return $isOk;
    }
}
