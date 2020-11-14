<?php


namespace EasyPanel\Commands;


use EasyPanel\EasyPanelServiceProvider;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class Install extends Command
{

    protected $signature = 'panel:install';

    protected $description = 'Install panel';

    public function handle()
    {
        $this->line("Installing Admin panel ...");

        Artisan::call('vendor:publish', [
            '--provider' => EasyPanelServiceProvider::class,
            '--tag' => 'easy-panel-styles'
        ]);

        Artisan::call('vendor:publish', [
            '--provider' => EasyPanelServiceProvider::class,
            '--tag' => 'easy-panel-views'
        ]);

        Artisan::call('vendor:publish', [
            '--provider' => EasyPanelServiceProvider::class,
            '--tag' => 'easy-panel-config'
        ]);

        Artisan::call('vendor:publish', [
            '--provider' => EasyPanelServiceProvider::class,
            '--tag' => 'easy-panel-migrations'
        ]);

        $this->alert("It was install fully :)) \n. If You update your CRUDs, Make sure you run the panel:crud command...");
    }
}
