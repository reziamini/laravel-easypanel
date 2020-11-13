<?php


namespace EasyPanel\Commands\Actions;


trait CommandParser
{

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
        //$this->showErrorIfClassExists();

        parent::handle();

        $this->buildBlade();
    }

}
