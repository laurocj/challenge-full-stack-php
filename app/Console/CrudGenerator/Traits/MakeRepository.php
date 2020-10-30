<?php

namespace App\Console\CrudGenerator\Traits;

trait MakeRepository
{
    /**
     * @param $name
     *
     * @return string
     */
    protected function _getRepositoryPath($name)
    {
        return $this->makeDirectory($this->_spacePath($this->repositoryNamespace) . "/{$name}Repository.php");
    }

    /**
     * Create Repository Class.
     *
     * @return $this
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildRepository()
    {
        $repositoryPath = $this->_getRepositoryPath($this->getNome());

        if ($this->files->exists($repositoryPath) && $this->ask('A Repository with that name already exists. Do you want to overwrite (s/n)?', 's') == 'n') {
            return $this;
        }

        $this->info('Creating the Repository ...');

        $replace = $this->buildReplacements();

        $repositoryTemplate = str_replace(
            array_keys($replace), array_values($replace), $this->getStub('Repository')
        );

        $this->write($repositoryPath, $repositoryTemplate);

        return $this;
    }
}
