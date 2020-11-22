<?php


namespace EasyPanel\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class MakeCRUDConfig extends GeneratorCommand
{

    protected $name = 'panel:config';
    protected $type = 'Create a config';

    protected $description = 'Make a crud config';

    protected function getStub()
    {
        return __DIR__.'/stub/crud.stub';
    }

    public function handle()
    {
        if(!$this->option()){
            $this->info("model option must have a value");
            return;
        }

        $name = strtolower($this->getNameInput());

        $stub = $this->files->get(__DIR__.'/stub/crud.stub');
        $newStub = $this->parseStub($stub);

        $path = resource_path("cruds/{$name}.php");

        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0755, true);
        }

        if($this->files->exists($path) and !$this->option('force')){
            $this->warn("'{$name}' exists in CRUDs config");
            return;
        }

        if($name != strtolower($this->option('model'))){
            $this->warn("'{$name}' must be equal to model name");
            return;
        }

        $this->files->put($path, $newStub);
        $this->info("{$name} option was created, You can manage it in : resources/cruds/{$name}.php");
    }

    private function parseStub($stub)
    {
        $model = $this->qualifyModel($this->option('model'));

        if(!class_exists($model)){
            $this->warn("Model option should be valid and model should be exist");
            die();
        }

        $array = [
            '{{ model }}' => $model,
        ];

        return str_replace(array_keys($array), array_values($array), $stub);
    }

    protected function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'force mode'],
            ['model', 'm', InputOption::VALUE_REQUIRED, 'model name'],
        ];
    }

}
