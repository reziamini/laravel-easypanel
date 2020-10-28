<?php


namespace AdminPanel\Commands;


use AdminPanel\AdminPanelServiceProvider;
use AdminPanel\Support\Contract\UserProviderFacade;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Install extends Command
{

    protected $signature = 'install:admin';

    protected $description = 'Install panel';

    public function handle()
    {
        $this->line("Installing Admin panel ...");
        Artisan::call('vendor:publish', [
            '--provider' => AdminPanelServiceProvider::class,
            '--tag' => 'admin-panel-styles'
        ]);

        Artisan::call('vendor:publish', [
            '--provider' => AdminPanelServiceProvider::class,
            '--tag' => 'admin-panel-views'
        ]);

        Artisan::call('vendor:publish', [
            '--provider' => AdminPanelServiceProvider::class,
            '--tag' => 'admin-panel-config'
        ]);

        Artisan::call('vendor:publish', [
            '--provider' => AdminPanelServiceProvider::class,
            '--tag' => 'admin-panel-migrations'
        ]);
        $this->alert("Admin panel was installed successfully");
    }

}
