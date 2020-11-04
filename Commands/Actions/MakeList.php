<?php


namespace AdminPanel\Commands\Actions;


use Illuminate\Console\GeneratorCommand;
use InvalidArgumentException;

class MakeList extends GeneratorCommand
{

    protected $name = 'crud:list';

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
        return $this->path.'\\Lists.php';
    }

    protected function getStub()
    {
        return __DIR__.'/../stub/list.stub';
    }

    private function replaceModel($stub)
    {
        $modelNamespace = $this->parseModel($this->getConfig('model'));
        $modelName = $this->getModelName($modelNamespace);

        $array = [
            '{{ modelName }}' => $modelName,
            '{{ modelNamespace }}' => $modelNamespace,
            '{{ model }}' => strtolower($modelName),
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

}
