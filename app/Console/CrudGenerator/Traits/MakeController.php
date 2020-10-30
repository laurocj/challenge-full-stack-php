<?php

namespace App\Console\CrudGenerator\Traits;

use Illuminate\Support\Str;

trait MakeController
{

    /**
     * @return array
     */
    protected function replaceParams()
    {
        $params = "";
        foreach ($this->getColumns() as $value) {

            if(in_array($value->Field,['id','created_at','updated_at','deleted_at']))
                continue;

            $params .= "\n\t\t\t\t\$request->".$this->normalizeName($value->Field).",";
       }

       $params = Str::replaceLast(',','',$params);

       return [
           '{{params}}' => $params
       ];
    }

    /**
     * @param $name
     *
     * @return string
     */
    protected function _getControllerPath($name)
    {
        return $this->_spacePath($this->controllerNamespace) . "/{$name}Controller.php";
    }

    /**
     * Creates the Controler class.
     *
     * @return $this
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildController()
    {
        $controllerPath = $this->_getControllerPath($this->getNome());

        if ($this->files->exists($controllerPath) && $this->ask('A Controller with that name already exists. Do you want to overwrite (s/n)?', 's') == 'n') {
            return $this;
        }

        $this->info('Creating a controller ...');

        $replace = array_merge($this->buildReplacements(),$this->replaceParams());

        $controllerTemplate = str_replace(
            array_keys($replace), array_values($replace), $this->getStub('Controller')
        );

        $this->write($controllerPath, $controllerTemplate);

        return $this;
    }
}
