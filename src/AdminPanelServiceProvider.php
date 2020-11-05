<?php


namespace AdminPanel;

use AdminPanel\Commands\{Actions\MakeCreate,
    Actions\MakeList,
    Actions\MakeSingle,
    Actions\MakeUpdate,
    CreateAll,
    DeleteAdmin,
    Install,
    MakeAdmin};
use AdminPanel\Http\Livewire\Todo\Create;
use AdminPanel\Http\Livewire\Todo\Lists;
use AdminPanel\Http\Livewire\Todo\Single;
use AdminPanel\Http\Middleware\isAdmin;
use AdminPanel\Support\Contract\{UserProviderFacade, AuthFacade};
use Illuminate\{Routing\Router, Support\Facades\Route, Support\ServiceProvider};
use Livewire\Livewire;

class AdminPanelServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/admin_panel_config.php', 'admin_panel');
        $this->defineFacades();
        $this->bindCommands();
    }

    public function boot()
    {
        if(!$this->app->runningInConsole()) {
            $this->registerMiddlewareAlias();

            $this->loadViewsFrom(__DIR__ . 'resources/views', 'admin');

            if (!$this->app->routesAreCached()) {
                $this->defineRoutes();
            }
        }

        $this->loadLivewireComponent();
        $this->mergePublishes();
    }

    private function defineRoutes()
    {
        $routeName = str_replace('/', '.', config('admin_panel.route_prefix'));
        Route::prefix(config('admin_panel.route_prefix'))
            ->middleware(['web', 'auth', 'isAdmin'])
            ->name($routeName.'.')
            ->group(__DIR__ . '/routes.php');
    }

    private function defineFacades()
    {
        AuthFacade::shouldProxyTo(config('admin_panel.auth_class'));
        UserProviderFacade::shouldProxyTo(config('admin_panel.admin_provider_class'));
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
        $this->publishes([__DIR__ . '/config/admin_panel_config.php' => config_path('admin_panel.php')], 'admin-panel-config');

        $this->publishes([__DIR__ . '/resources/views' => resource_path('/views/vendor/admin')], 'admin-panel-views');

        $this->publishes([__DIR__ . '/resources/assets' => public_path('/assets/vendor/admin'), __DIR__ . '/resources/dist' => public_path('/dist/vendor/admin')], 'admin-panel-styles');

        $this->publishes([__DIR__ . '/database/migrations/2020_10_27_115952_create_todos_table.php' => base_path('/database/migrations/' . date('Y_m_d') . '_99999_create_todos_table.php')], 'admin-panel-migrations');
    }

    private function bindCommands()
    {
        $this->commands([
            MakeAdmin::class,
            DeleteAdmin::class,
            Install::class,
            MakeCreate::class,
            MakeUpdate::class,
            MakeList::class,
            MakeSingle::class,
            CreateAll::class
        ]);
    }

}
