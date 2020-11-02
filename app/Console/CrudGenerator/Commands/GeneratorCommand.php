<?php

namespace App\Console\CrudGenerator\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class GeneratorCommand.
 */
abstract class GeneratorCommand extends Command
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Table name from argument.
     *
     * @var string
     */
    protected $table = null;

    /**
     * Formatted Class name from Table.
     *
     * @var string
     */
    protected $name = null;

    /**
     * Store the DB table columns.
     *
     * @var array
     */
    private $tableColumns = null;

    /**
     * Rules for the validator
     *
     * @var array
     */
    private $rulesArray = [];

    /**
     * Model Namespace.
     *
     * @var string
     */
    protected $modelNamespace = 'Entities';

    /**
     * Service Namespace.
     *
     * @var string
     */
    protected $serviceNamespace = 'Services';

    /**
     * Repository Namespace.
     *
     * @var string
     */
    protected $repositoryNamespace = 'Repository';

    /**
     * Controller Namespace.
     *
     * @var string
     */
    protected $controllerNamespace = 'Http\Controllers';

    /**
     * Request Namespace.
     *
     * @var string
     */
    protected $requestNamespace = 'Http\Requests';

    /**
     * Custom Options name
     *
     * @var array
     */
    protected $options = [];

    /**
     * Create a new controller creator command instance.
     *
     * @param \Illuminate\Filesystem\Filesystem $files
     *
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->files = $files;
    }

    /**
     * Build the directory if necessary.
     *
     * @param string $path
     *
     * @return string
     */
    protected function makeDirectory($path)
    {
        if (!$this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0777, true, true);
        }

        return $path;
    }

    /**
     * @param string $name
     * @return string
     */
    protected function normalizeName(string $name)
    {
        return str_replace(['-','__'],'_',Str::snake($name));
    }

    /**
     * Write the file/Class.
     *
     * @param string $path
     * @param string $content
     */
    protected function write($path, $content)
    {
        $this->files->put($path, $content);
    }

    /**
     * @param string $name
     *
     * @return string
     */
    protected function _getPath($namespace)
    {
        return module_path($this->getModule(), $namespace);
    }

    /**
     * @param string $namespace
     *
     * @return string
     */
    protected function _spacePath($namespace)
    {
        return module_path($this->getModule(), $namespace);
    }

    /**
     * @param string $namespace
     *
     * @return string
     */
    private function space($namespace)
    {
        return config('modules.namespace')."\\".$this->getModule().'\\'.$namespace;
    }

    /**
     * @return string
     */
    protected function getModelName()
    {
        return $this->getNome();
    }

    /**
     * @return string
     */
    protected function getModelTitle()
    {
        return Str::title(Str::snake($this->getNome(), ' '));
    }

    /**
     * @return string
     */
    protected function getModelNamespace()
    {
        return $this->space($this->modelNamespace);
    }

    /**
     * @return string
     */
    protected function getServiceNamespace()
    {
        return $this->space($this->serviceNamespace);
    }

    /**
     * @return string
     */
    protected function getRepositoryNamespace()
    {
        return $this->space($this->repositoryNamespace);
    }

    /**
     * @return string
     */
    protected function getControllerNamespace()
    {
        return $this->space($this->controllerNamespace);
    }

    /**
     * @return string
     */
    protected function getRequestNamespace()
    {
        return $this->space($this->requestNamespace);
    }

    /**
     * @return string
     */
    protected function getModuleLower()
    {
        return strtolower($this->getModule());
    }

    /**
     * @return string
     */
    protected function getModelNamePluralLowerCase()
    {
        return Str::camel(Str::plural($this->getNome()));
    }

    /**
     * @return string
     */
    protected function getModelNamePluralUpperCase()
    {
        return ucfirst(Str::plural($this->getNome()));
    }

    /**
     * @return string
     */
    protected function getModelNameLowerCase()
    {
        return Str::camel($this->getNome());
    }

    /**
     * @return string
     */
    protected function getRouterName()
    {
        return Str::kebab(Str::plural($this->getNome()));
    }

    /**
     * @return string
     */
    protected function getPathViewsName()
    {
        return Str::kebab($this->getNome());
    }

    /**
     * Build the replacement.
     *
     * @return array
     */
    protected function buildReplacements()
    {
        return [
            '{{modelName}}'                 => $this->getModelName(),
            '{{modelTitle}}'                => $this->getModelTitle(),
            '{{modelNamespace}}'            => $this->getModelNamespace(),
            '{{serviceNamespace}}'          => $this->getServiceNamespace(),
            '{{repositoryNamespace}}'       => $this->getRepositoryNamespace(),
            '{{controllerNamespace}}'       => $this->getControllerNamespace(),
            '{{requestNamespace}}'          => $this->getRequestNamespace(),
            '{{moduleLower}}'               => $this->getModuleLower(),
            '{{modelNamePluralLowerCase}}'  => $this->getModelNamePluralLowerCase(),
            '{{modelNamePluralUpperCase}}'  => $this->getModelNamePluralUpperCase(),
            '{{modelNameLowerCase}}'        => $this->getModelNameLowerCase(),
            '{{modelRoute}}'                => $this->getRouterName(),
            '{{modelView}}'                 => $this->getPathViewsName(),
        ];
    }

    /**
     * Get the DB Table columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        if (empty($this->tableColumns)) {
            $this->tableColumns = DB::select('SHOW COLUMNS FROM ' . $this->getTable());
        }

        return $this->tableColumns;
    }

    /**
     * Get the name of the entry table.
     *
     * @return string
     */
    protected function getTable()
    {
        return trim($this->argument('table'));
    }

    /**
     * Obtain the name of the entry module.
     *
     * @return string
     */
    protected function getModule()
    {
        return trim($this->argument('module'));
    }

    /**
     * Get the alias that will be used instead of the table name.
     *
     * @return string
     */
    protected function getNome()
    {
        if($this->hasOption('alias') && !is_null($this->option('alias'))){
            return $this->_buildClassName($this->option('alias'));
        }
        return $this->_buildClassName($this->getTable());
    }

    /**
     * @param string $name
     * @return string
     */
    protected function _buildClassName($name)
    {
        return Str::studly(Str::singular($name));
    }

    /**
     * Get the command arguments from the console.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['table', InputArgument::REQUIRED, 'The name of the table.'],
            ['module', InputArgument::REQUIRED, 'The name of the module.'],
        ];
    }

    /**
     * @return mixed
     */
    protected function tableExists()
    {
        return Schema::hasTable($this->getTable());
    }

    /**
     * Get the stub file.
     *
     * @param string $type
     * @param boolean $content
     *
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     *
     */
    protected function getStub($type, $content = true)
    {
        $path = __DIR__ . "/../stubs/{$type}.stub";

        if (!$content) {
            return $path;
        }

        return $this->files->get($path);
    }
}
