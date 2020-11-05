<?php


namespace AdminPanel\Commands;


use AdminPanel\AdminPanelServiceProvider;
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

        if(config('admin_panel.actions')) {
            $this->line("Creating CRUDs...");
            $result = $this->confirm("Do you want to create CRUDs ?", 'yes');
            if ($result) {
                $this->line("Admin panel was installed successfully, Let me create your CRUDs");
                foreach (config('admin_panel.actions') as $action => $value) {
                    Artisan::call('crud:all', ['name' => $action]);
                }
            }
        }

        $this->info("It was install fully. If you update your CRUDs, Make sure you rerun this command...");
    }
}
