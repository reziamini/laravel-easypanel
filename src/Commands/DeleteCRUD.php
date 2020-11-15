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
        $names = (array) $this->argument('name') ?: array_keys(config('easy_panel.actions', []));
        if($names == null) {
            throw new CommandNotFoundException("There is no action in config file");
        }

        foreach ($names as $name) {
            if (!array_key_exists($name, config('easy_panel.actions'))) {
                $this->line("$name does not exists in config file");
                continue;
            }
            File::deleteDirectory(resource_path("/views/livewire/admin/$name"));
            File::deleteDirectory(app_path("/Http/Livewire/Admin/" . ucfirst($name)));
            $this->info("{$name} files were deleted, make sure you run panel:crud to create files again");
        }
    }

}
