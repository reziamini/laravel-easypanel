<?php


namespace AdminPanel\Commands\Actions;


use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use InvalidArgumentException;

class MakeList extends GeneratorCommand
{

    use StubParser;

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

    public function buildBlade()
    {
        $stub = $this->files->get(__DIR__ . '/../stub/blade/list.blade.stub');
        $newStub = $this->parseBlade($stub);

        $path = $this->viewPath("livewire/admin/{$this->getNameInput()}/list.blade.php");

        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0755, true);
        }

        $this->files->put($path, $newStub);
    }

    public function handle()
    {
        parent::handle();

        $this->buildBlade();

        Artisan::call('crud:single', [
            'name' => $this->getNameInput()
        ]);
    }
}
