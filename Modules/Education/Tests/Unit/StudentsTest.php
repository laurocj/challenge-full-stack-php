<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase;
use Modules\Education\Entities\Student;
use Modules\Education\Repository\StudentRepository;
use Modules\Education\Services\StudentService;

class StudentsTest extends TestCase
{
    protected $userMock;

    protected function setUp() : void
    {
        parent::setUp();

        $this->mock = Mockery::mock(StudentRepository::class);
    }

    /**
     */
    public function testDoesNotAllowChangingAStudent()
    {
        $id = 1;
        $name = "Aluno teste";
        $email = "aluno@teste.com";
        $academic_record = "123456";
        $cpf = "12346578945";

        $studentFake = new Student;
        $studentFake->id = 1;
        $studentFake->name = $name;
        $studentFake->email = $email;
        $studentFake->academic_record = $academic_record;
        $studentFake->cpf = $cpf;

        $this->mock->shouldReceive('save')->andReturn(true);
        $this->mock->shouldReceive('find')->with(1)->andReturn($studentFake);

        $service = new StudentService($this->mock);

        $isOk = $service->update(
            $id,
            $name,
            $email
        );

        $this->assertTrue($isOk);
    }
}
