<?php

namespace EasyPanel\Commands\Actions;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class Uninstall extends Command
{

    protected $signature = 'panel:uninstall {--f|force : Force mode}';
    protected $description = 'Uninstall the panel';

    public function handle()
    {
        $status = $this->option('force')
            ? true
            : $this->confirm("Do you really want to uninstall the panel ? (All files and components will be deleted)", true);

        if($status){
            File::deleteDirectory(app_path('Http/Livewire/Admin'));
            File::deleteDirectory(app_path('CRUD'));
            File::deleteDirectory(resource_path('views/livewire/admin'));
            File::deleteDirectory(resource_path('views/vendor/admin'));
            File::deleteDirectory(resource_path('cruds'));
            File::deleteDirectory(public_path('assets/admin'));
            File::delete(config_path('easy_panel.php'));
            $this->info("All files and components was deleted!");

            return;
        }

        $this->info("The process was canceled");
    }

}
