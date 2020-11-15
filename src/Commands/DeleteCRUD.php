<?php

namespace EasyPanel\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Exception\CommandNotFoundException;

class DeleteCRUD extends Command
{

    protected $signature = 'panel:delete {name?} {--force : Force mode}';

    protected $description = 'Create all action for CRUDs';

    public function handle()
    {
        $names = $this->argument('name') ? [$this->argument('name')] : array_keys(config('easy_panel.actions', []));
        if($names == null) {
            throw new CommandNotFoundException("There is no action in config file");
        }
        foreach ($names as $name) {
            dump($name);
            //File::deleteDirectory();
        }
    }

}
