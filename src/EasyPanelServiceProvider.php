<?php


namespace EasyPanel;

use EasyPanel\Commands\{Actions\MakeCreate,
    MakeCRUDConfig,
    Actions\MakeRead,
    Actions\MakeSingle,
    Actions\MakeUpdate,
    DeleteCRUD,
    MakeCRUD,
    DeleteAdmin,
    Install,
    MakeAdmin};
use EasyPanel\Http\Livewire\Todo\Create;
use EasyPanel\Http\Livewire\Todo\Lists;
use EasyPanel\Http\Livewire\Todo\Single;
use EasyPanel\Http\Middleware\isAdmin;
use EasyPanel\Support\Contract\{UserProviderFacade, AuthFacade};
use Illuminate\{Routing\Router, Support\Facades\File, Support\Facades\Route, Support\ServiceProvider};
use Livewire\Livewire;

class EasyPanelServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/easy_panel_config.php', 'easy_panel');
        if(!config('easy_panel.enable')) {
            return;
        }

        $this->defineFacades();
        $this->bindCommands();

        foreach (config('easy_panel.actions') as $action) {
            if(!File::exists(resource_path("cruds/$action.php"))) {
                continue;
            }
            $data = require resource_path("cruds/$action.php");
            config()->set("easy_panel.crud.$action", $data);
        }
    }

    public function boot()
    {
        if(!config('easy_panel.enable')) {
            return;
        }

        if ($this->app->runningInConsole()) {
            $this->mergePublishes();
        }

        // Load Views
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'admin');

        // Register Middleware
        $this->registerMiddlewareAlias();

        // Define routes if doesn't cached
        $this->defineRoutes();

        // Load Livewire TODOs components
        $this->loadLivewireComponent();
    }

    private function defineRoutes()
    {
        if(!$this->app->routesAreCached()) {
            Route::prefix(config('easy_panel.route_prefix'))
                ->middleware(['web', 'auth', 'isAdmin'])
                ->name(getRouteName() . '.')
                ->group(__DIR__ . '/routes.php');
        }
    }

    private function defineFacades()
    {
        AuthFacade::shouldProxyTo(config('easy_panel.auth_class'));
        UserProviderFacade::shouldProxyTo(config('easy_panel.admin_provider_class'));
    }

    private function registerMiddlewareAlias()
    {
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('isAdmin', isAdmin::class);
    }

    private function loadLivewireComponent()
    {
        Livewire::component('admin::livewire.todo.single', Single::class);
        Livewire::component('admin::livewire.todo.create', Create::class);
        Livewire::component('admin::livewire.todo.lists', Lists::class);
    }

    private function mergePublishes()
    {
        $this->publishes([__DIR__ . '/../config/easy_panel_config.php' => config_path('easy_panel.php')], 'easy-panel-config');

        $this->publishes([__DIR__ . '/../resources/views' => resource_path('/views/vendor/admin')], 'easy-panel-views');

        $this->publishes([__DIR__ . '/../resources/assets' => public_path('/assets/admin')], 'easy-panel-styles');

        $this->publishes([__DIR__ . '/../database/migrations/2020_09_05_99999_create_todos_table.php' => base_path('/database/migrations/' . date('Y_m_d') . '_99999_create_admin_todos_table.php')], 'easy-panel-migrations');

        $this->publishes([__DIR__.'/../resources/cruds' => resource_path('/cruds')], 'easy-panel-cruds');
    }

    private function bindCommands()
    {
        $this->commands([
            MakeAdmin::class,
            DeleteAdmin::class,
            Install::class,
            MakeCreate::class,
            MakeUpdate::class,
            MakeRead::class,
            MakeSingle::class,
            MakeCRUD::class,
            DeleteCRUD::class,
            MakeCRUDConfig::class
        ]);
    }
}
