<?php

namespace App\Console\CrudGenerator\Commands;

use App\Console\CrudGenerator\Traits\MakeController;
use App\Console\CrudGenerator\Traits\MakeModel;
use App\Console\CrudGenerator\Traits\MakeRepository;
use App\Console\CrudGenerator\Traits\MakeRequest;
use App\Console\CrudGenerator\Traits\MakeService;
use App\Console\CrudGenerator\Traits\MakeViews;

/**
 * Class CrudGenerator.
 */
class CrudGenerator extends GeneratorCommand
{
    use MakeController,
        MakeModel,
        MakeRepository,
        MakeRequest,
        MakeService,
        MakeViews;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generator:make-crud
                            {table : Table name}
                            {module : Module name}
                            {--alias= : The name that will be used instead of the table name.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an initial CRUD for development.';

    /**
     * @return bool|null
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle()
    {
        $this->info('Running the CRUD generator ...');

        if (!$this->tableExists()) {
            $this->error("`{$this->getTable()}` this table does not exist.");

            return false;
        }

        // Gera as partes do CRUD
        $this->buildController()
            ->buildModel()
            ->buildViews()
            ->buildService()
            ->buildRepository()
            ->buildRequest();

        $this->info('Successfully created.');

        return true;
    }
}
