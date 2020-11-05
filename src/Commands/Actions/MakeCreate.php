<?php


namespace AdminPanel\Commands\Actions;


use Illuminate\Console\GeneratorCommand;
use Illuminate\Filesystem\Filesystem;
use InvalidArgumentException;

class MakeCreate extends GeneratorCommand
{

    use StubParser;

    protected $name = 'crud:create';

    private $path;

    protected $type = 'Create Action';

    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);
        $stub = $this->replaceModel($stub);

        return $stub;
    }

    protected function getPath($name)
    {
        return $this->path.'\\Create.php';
    }

    protected function getStub()
    {
        return __DIR__.'/../stub/create.stub';
    }

    private function buildBlade()
    {
        $stub = $this->files->get(__DIR__ . '/../stub/blade/create.blade.stub');
        $newStub = $this->parseBlade($stub);

        $path = $this->viewPath("livewire/admin/{$this->getNameInput()}/create.blade.php");

        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0755, true);
        }

        $this->files->put($path, $newStub);
    }

    public function handle()
    {
        parent::handle();

        $this->buildBlade();
    }

}
