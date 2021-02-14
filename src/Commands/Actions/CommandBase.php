<?php

namespace EasyPanel\Commands\Actions;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

abstract class CommandBase extends GeneratorCommand
{

    public function getDefaultNamespace($rootNamespace)
    {
        $name = ucfirst($this->getNameInput());
        $this->path = parent::getDefaultNamespace($rootNamespace)."\\Http\\Livewire\\Admin\\$name";

        return $this->path;
    }

    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);
        $stub = $this->replaceModel($stub);

        return $stub;
    }

    protected function getPath($name)
    {
        $fileName = ucfirst($this->file);
        return "{$this->path}\\{$fileName}.php";
    }

    protected function getStub()
    {
        return __DIR__ . "/../stub/{$this->file}.stub";
    }

    private function buildBlade()
    {
        $stub = $this->files->get(__DIR__ . "/../stub/blade/{$this->file}.blade.stub");
        $newStub = $this->parseBlade($stub);

        $path = $this->viewPath("livewire/admin/{$this->getNameInput()}/{$this->file}.blade.php");

        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0755, true);
        }

        $this->files->put($path, $newStub);
    }

    public function handle()
    {
        if ($this->isReservedName($this->getNameInput())) {
            $this->error("The name '{$this->getNameInput()}' is reserved by PHP.");
            return false;
        }

        $name = $this->qualifyClass($this->getNameInput());
        $path = $this->getPath($name);

        if ($this->alreadyExists($this->getNameInput()) and !$this->option('force')) {
            $this->line("<options=bold,reverse;fg=red> • {$this->getNameInput()} {$this->type} already exists! </> \n");

            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->sortImports($this->buildClass($name)));

        $this->buildBlade();
        $this->line("<options=bold,reverse;fg=green> {$this->getNameInput()} {$this->type} created successfully. </> 🤙\n");
    }

    protected function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'force mode']
        ];
    }

}
