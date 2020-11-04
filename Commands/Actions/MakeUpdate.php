<?php


namespace AdminPanel\Commands\Actions;


use Illuminate\Console\GeneratorCommand;
use InvalidArgumentException;

class MakeUpdate extends GeneratorCommand
{

    use StubParser;

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

}
