<?php


namespace AdminPanel\Commands\Actions;


use Illuminate\Console\GeneratorCommand;
use InvalidArgumentException;

class MakeSingle extends GeneratorCommand
{

    use StubParser;

    protected $name = 'crud:single';

    private $path;

    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);
        $stub = $this->replaceModel($stub);

        return $stub;
    }

    protected function getPath($name)
    {
        return $this->path.'\\Single.php';
    }

    protected function buildBlade()
    {
        $stub = $this->files->get(__DIR__ . '/../stub/blade/single.blade.stub');
        $newStub = $this->parseBlade($stub);

        $path = $this->viewPath("livewire/admin/{$this->getNameInput()}/single.blade.php");

        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0755, true);
        }

        $this->files->put($path, $newStub);
    }

    protected function getStub()
    {
        return __DIR__.'/../stub/single.stub';
    }

    public function handle()
    {
        parent::handle();

        $this->buildBlade();
    }
}
