<?php

namespace EasyPanel\Commands\CRUDActions;

use EasyPanel\Parsers\StubParser;
use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Illuminate\Support\Str;

abstract class CommandBase extends GeneratorCommand
{

    /**
     * @var StubParser
     */
    private $stubParser;

    protected $path;

    public function getDefaultNamespace($rootNamespace)
    {
        $name = ucfirst($this->getNameInput());
        $this->path = parent::getDefaultNamespace($rootNamespace).DIRECTORY_SEPARATOR."Http".DIRECTORY_SEPARATOR."Livewire".DIRECTORY_SEPARATOR."Admin".DIRECTORY_SEPARATOR."$name";

        return $this->path;
    }

    protected function buildClass($name)
    {
        $stub = parent::buildClass($name);
        $stub = $this->stubParser->replaceModel($stub);

        return $stub;
    }

    protected function getPath($name)
    {
        $fileName = ucfirst($this->file);
        return "{$this->path}".DIRECTORY_SEPARATOR."{$fileName}.php";
    }

    protected function getStub()
    {
        return $this->resolveStubPath("{$this->file}.stub");
    }

    private function buildBlade()
    {
        $stub = $this->files->get($this->resolveStubPath("blade".DIRECTORY_SEPARATOR."{$this->file}.blade.stub"));
        $newStub = $this->stubParser->parseBlade($stub);

        $path = $this->viewPath("livewire".DIRECTORY_SEPARATOR."admin".DIRECTORY_SEPARATOR."{$this->getNameInput()}".DIRECTORY_SEPARATOR."{$this->file}.blade.php");

        if (! $this->files->isDirectory(dirname($path))) {
            $this->files->makeDirectory(dirname($path), 0755, true);
        }

        $this->files->put($path, $newStub);
    }

    public function handle()
    {

        $this->setStubParser();

        if ($this->isReservedName($this->getNameInput())) {
            $this->error("The name '{$this->getNameInput()}' is reserved by PHP.");
            return false;
        }

        $name = $this->qualifyClass($this->getNameInput());
        $path = $this->getPath($name);
        $path = str_replace('App', 'app', $path);

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

    private function setStubParser()
    {
        $model = config("easy_panel.crud.{$this->getNameInput()}.model");
        $parsedModel = $this->qualifyModel($model);
        $this->stubParser = new StubParser($this->getNameInput(), $parsedModel);
        $this->setDataToParser();
    }

    private function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim("stubs/panel/".$stub, '/')))
            ? $customPath
            : __DIR__.'/../stub/'.$stub;
    }

    protected function qualifyModel($model)
    {
        $model = ltrim($model, '\\/');

        $model = str_replace('/', '\\', $model);

        $rootNamespace = $this->rootNamespace();

        if (Str::startsWith($model, $rootNamespace)) {
            return $model;
        }

        return is_dir(app_path('Models'))
            ? $rootNamespace.'Models\\'.$model
            : $rootNamespace.$model;
    }

    private function setDataToParser(): void
    {
        $config = config("easy_panel.crud." . $this->getNameInput());
        $this->stubParser->setAuthType($config['with_auth']);
        $this->stubParser->setInputs($config['fields']);
        $this->stubParser->setFields($config['show']);
        $this->stubParser->setStore($config['store']);
        $this->stubParser->setValidationRules($config['validation']);
    }
}
