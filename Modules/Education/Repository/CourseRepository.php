<?php

namespace Modules\Education\Repository;

use Modules\Education\Entities\Course;
use App\Repository\GenericRepository;

class CourseRepository
{
    // basic operations
    use GenericRepository;

    /**
     * Construtct
     */
    public function __construct()
    {
        $this->query = Course::query();
    }
}
