<?php

namespace EasyPanel\Commands\Actions;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Reinstall extends Command
{

    protected $signature = 'panel:reinstall {--acl : Install ACL system}';
    protected $description = 'Reinstall whole the package';

    public function handle()
    {
        $status = $this->confirm("Do you really want to reinstall the panel ? (All components will be deleted)", true);

        if(!$status) {
            $this->info("The process was canceled");
            return;
        }

        Artisan::call("panel:uninstall", [
            '--force' => true,
        ]);

        Artisan::call("panel:install", ['--acl' => $this->option('acl')]);

        $this->info("The package was reinstalled!");
    }
}
