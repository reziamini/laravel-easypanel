<?php

namespace EasyPanel\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Exception\CommandNotFoundException;

class MakeCRUD extends Command
{

    protected $signature = 'panel:crud {name?} {--f|force : Force mode}';

    protected $description = 'Create all action for CRUDs';

    public function handle()
    {
        $names = $this->argument('name') ? [$this->argument('name')] : config('easy_panel.actions', []);

        if(is_null($names)) {
            throw new CommandNotFoundException("There is no action in config file");
        }

        foreach ($names as $name) {
            $args = ['name' => $name, '--force' => $this->option('force')];

            $config = config("easy_panel.crud.$name");

            if (!$config) {
                throw new CommandNotFoundException("There is no {$name} in config file");
            }

            $this->modelNameIsCorrect($name, $config['model']);

            $this->createActions($config, $name, $args);
        }
    }

    private function modelNameIsCorrect($name, $model)
    {
        $model = explode('\\', $model);
        $model = strtolower(end($model));

        if($model != $name){
            throw new CommandNotFoundException("Action key should be equal to model name, You are using {$name} as key name but your model name is {$model}");
        }
    }


    private function createActions($config, $name, $args)
    {
        if (isset($config['create']) and $config['create']) {
            $this->call('panel:create', $args);
        } else {
            $this->warn("The create action is disabled for {$name}");
        }

        if (isset($config['update']) and $config['update']) {
            $this->call('panel:update', $args);
        } else {
            $this->warn("The update action is disabled for {$name}");
        }

        $this->call('panel:read', $args);
        $this->call('panel:single', $args);
    }

}
