<?php

namespace Modules\Education\Repository;

use Modules\Education\Entities\Student;
use App\Repository\GenericRepository;

class StudentRepository
{
    // operações basicas de pesquisa
    use GenericRepository;

    /**
     * Construtor
     */
    public function __construct()
    {
        $this->query = Student::query();
    }
}
