<?php

namespace EasyPanel\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
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
        if(!$this->option('model')){
            $this->error("Model option must have a value");
            return;
        }

        $name = strtolower($this->getNameInput());

        if($name != strtolower($this->option('model'))){
            $this->warn("'{$name}' must be equal to model name");
            return;
        }

        $path = resource_path("cruds/{$name}.php");

        if($this->files->exists($path) and !$this->option('force')){
            $this->warn("'{$name}' already exists in CRUDs config");
            return;
        }

        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0755, true);
        }

        $stub = $this->files->get(__DIR__.'/stub/crud.stub');
        $newStub = $this->parseStub($stub);

        $this->files->put($path, $newStub);
        $this->info("{$name} option was created, You can manage it in : resources/cruds/{$name}.php");
    }

    private function parseStub($stub)
    {
        $array = [
            '{{ model }}' => $this->parseModel(),
            '{{ withAuth }}' => $this->withAuth(),
            '{{ searchFields }}' => $this->parseSearchFields(),
        ];

        return str_replace(array_keys($array), array_values($array), $stub);
    }

    protected function getOptions()
    {
        return [
            ['model', 'm', InputOption::VALUE_REQUIRED, 'Model name'],
            ['force', 'f', InputOption::VALUE_NONE, 'force mode'],
        ];
    }

    private function parseModel()
    {
        $model = $this->qualifyModel($this->option('model'));

        if(!class_exists($model)){
            $this->warn("Model option should be valid and model should be exist");
            die();
        }

        return $model;
    }

    private function withAuth()
    {
        $fillableList = $this->getFillableList();
        if(!in_array('user_id', $fillableList)){
            return 'true';
        }

        return 'false';
    }

    private function getFillableList()
    {
        $modelNamespace = $this->qualifyModel($this->option('model'));
        $modelInstance = new $modelNamespace;
        return $modelInstance->getFillable();
    }

    private function parseSearchFields()
    {
        $fillableList = $this->getFillableList();
        $array = [];
        foreach ($fillableList as $fillable){
            if(!Str::contains($fillable, 'id')){
                $array[] = "'$fillable'";
            }
        }

        return implode(', ', $array);
    }

}
