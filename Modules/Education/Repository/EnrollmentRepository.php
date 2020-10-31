<?php

namespace Modules\Education\Repository;

use Modules\Education\Entities\Enrollment;
use App\Repository\GenericRepository;

class EnrollmentRepository
{
    // basic operations
    use GenericRepository;

    /**
     * Construtct
     */
    public function __construct()
    {
        $this->query = Enrollment::query();
    }
}
