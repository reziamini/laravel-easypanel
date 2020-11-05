<?php


namespace AdminPanel\Commands;


use AdminPanel\Support\Contract\UserProviderFacade;
use Illuminate\Console\Command;
use Symfony\Component\Console\Exception\CommandNotFoundException;

class CreateAll extends Command
{

    protected $signature = 'crud:all {name?}';

    protected $description = 'Create all action for CRUDs';

    public function handle()
    {
        $names = $this->argument('name') ? [$this->argument('name')] : array_keys(config('admin_panel.actions', []));

        foreach ($names as $name) {
            $config = config('admin_panel.actions.' . $name);
            if(!$config) {
                throw new CommandNotFoundException("There is no {$name} in config file");
            }

            if(!$config['create']){
                $this->warn('The create action is disabled');
            } else {
                $this->call('crud:create', [ 'name' => $name ]);
            }

            if(!$config['update']){
                $this->warn('The update action is disabled');
            } else {
                $this->call('crud:update', [ 'name' => $name ]);
            }

            $this->call('crud:list', [ 'name' => $name ]);
        }
    }

}
