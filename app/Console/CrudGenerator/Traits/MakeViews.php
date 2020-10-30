<?php

namespace App\Console\CrudGenerator\Traits;

use Illuminate\Support\Str;

trait MakeViews
{
    /**
     * @param $view
     *
     * @return string
     */
    protected function _getViewPath($view)
    {
        $name = Str::kebab($this->getNome());

        return $this->makeDirectory($this->_spacePath("Resources/views/{$name}/{$view}.blade.php"));
    }

    /**
     * Creates the Views
     *
     * @return $this
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildViews()
    {
        $this->info('Creating the Views ...');

        $replace = array_merge($this->buildReplacements(),$this->viewReplacements());

        foreach (['index', 'create', 'edit'] as $view) {
            $viewTemplate = str_replace(
                array_keys($replace), array_values($replace), $this->getStub("views/{$view}")
            );

            $this->write($this->_getViewPath($view), $viewTemplate);
        }

        return $this;
    }

    /**
     * Make view attributes/replacements.
     *
     * @return array
     */
    protected function viewReplacements()
    {
        $fieldMapUpdate = '';
        $fieldMapCreate = '';

        foreach ($this->getColumns() as $value) {

            if ($value->Key != 'PRI' && $value->Field != 'deleted_at' && $value->Field != 'created_at' && $value->Field != 'updated_at') {

                $type = 'text';
                if (Str::is('*int*', $value->Type)) {
                    $type = 'number';
                } else if (Str::is('*date*', $value->Type) || Str::is('*time*', $value->Type)) {
                    $type = 'date';
                }

                $fieldMapCreate .= $this->getField($type, $value->Field);
                $fieldMapUpdate .= $this->getField($type, $value->Field, true);
            }
        }

        return [
            '{{fieldMapUpdate}}' => $fieldMapUpdate,
            '{{fieldMapCreate}}' => $fieldMapCreate
        ];
    }

    /**
     * Build the form fields for form.
     *
     * @param $type
     * @param $column
     * @param string $type
     *
     * @return mixed
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     *
     */
    protected function getField($type, $column, $value = false)
    {
        $replace = array_merge($this->buildReplacements(), [
            '{{type}}' => $type,
            '{{column}}' => $column,
            '{{title}}' => str_replace(['-','_'],' ', ucfirst($column)),
            '{{value}}' =>  $value ? $this->getValue($column) : ''
        ]);

        return str_replace(
            array_keys($replace), array_values($replace), $this->getStub("views/form-field")
        );
    }

    /**
     * @param $column
     *
     * @return mixed
     */
    protected function getValue($column)
    {
        $replace = $this->buildReplacements();

        return str_replace(
            array_keys($replace),
            array_values($replace),
            ",\n\t\t\t".'"value" => ${{modelNameLowerCase}}->'.$column
        );
    }
}
