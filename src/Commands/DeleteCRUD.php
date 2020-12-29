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
        $names = (array) $this->argument('name') ?: config('easy_panel.actions', []);
        if($names == null) {
            throw new CommandNotFoundException("There is no action in config file");
        }

        foreach ($names as $name) {
            if (!in_array($name, config('easy_panel.actions'))) {
                $this->line("$name does not exist in config file");
                continue;
            }

            if ($this->askResult($name)) {
                File::deleteDirectory(resource_path("/views/livewire/admin/$name"));
                File::deleteDirectory(app_path("/Http/Livewire/Admin/" . ucfirst($name)));
                $this->info("{$name} files were deleted, make sure you will delete {$name} value from actions in config");
            } else {
                $this->line("process for {$name} action was canceled.");
            }

        }
    }

    public function askResult($name)
    {
        if($this->option('force')) {
            return true;
        }
        $result = $this->confirm("Do you really want to delete {$name} files ?", true);
        return $result;
    }

}
