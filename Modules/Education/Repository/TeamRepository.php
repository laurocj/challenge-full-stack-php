<?php

namespace Modules\Education\Repository;

use Modules\Education\Entities\Team;
use App\Repository\GenericRepository;

class TeamRepository
{
    // basic operations
    use GenericRepository;

    /**
     * Construtct
     */
    public function __construct()
    {
        $this->query = Team::query();
    }
}
