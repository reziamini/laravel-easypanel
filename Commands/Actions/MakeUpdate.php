<?php


namespace AdminPanel\Commands\Actions;


use Illuminate\Console\GeneratorCommand;
use InvalidArgumentException;

class MakeUpdate extends GeneratorCommand
{

    protected $name = 'crud:update';

    private $path;

    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);

        $stub = $this->replaceModel($stub);

        return $stub;
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        $name = ucfirst($this->getNameInput());
        $this->path = parent::getDefaultNamespace($rootNamespace)."\\Http\\Livewire\\$name";

        return $this->path;
    }

    protected function getPath($name)
    {
        return $this->path.'\\Update.php';
    }

    protected function getStub()
    {
        return __DIR__.'/../stub/update.stub';
    }

    private function replaceModel($stub)
    {
        $modelNamespace = $this->parseModel($this->getConfig('model'));
        $modelName = $this->getModelName($modelNamespace);

        $array = [
            '{{ modelName }}' => $modelName,
            '{{ modelNamespace }}' => $modelNamespace,
            '{{ model }}' => strtolower($modelName),
            '{{ properties }}' => $this->parseProperties(),
            '{{ rules }}' => $this->parseValidationRules(),
            '{{ fields }}' => $this->parseFields(),
        ];

        return str_replace(array_keys($array), array_values($array), $stub);
    }

    private function parseModel($model)
    {
        if (preg_match('([^A-Za-z0-9_/\\\\])', $model)) {
            throw new InvalidArgumentException('Model name contains invalid characters.');
        }

        return $this->qualifyModel($model);
    }

    private function getConfig($key){
        $action = $this->getNameInput();

        return config('admin_panel.actions.'.$action.'.'.$key);
    }

    private function getModelName($modelNamespace)
    {
        $array = explode('\\', $modelNamespace);

        return end($array);
    }

    private function parseProperties()
    {
        $fields = $this->getConfig('fields');
        $fields = array_keys($fields);

        $str = '';
        foreach ($fields as $field) {
            $str .= 'public $'.$field.";\n    ";
        }

        return $str;
    }

    private function parseValidationRules()
    {
        $fields = $this->getConfig('validation');
        $str = '';
        foreach ($fields as $key => $field) {
            $str .= $field != end($fields) ? "'$key' => '$field',\n        "
                : "'$key' => '$field',";
        }

        return $str;
    }

    private function parseFields()
    {
        $fields = $this->getConfig('fields');
        $str = '';
        foreach ($fields as $key => $field) {
            $str .= $field != end($fields) ?
                "'$key' => ".'$this'."->$key,\n            "
                : "'$key' => ".'$this'."->$key,";
        }

        return $str;
    }

}
