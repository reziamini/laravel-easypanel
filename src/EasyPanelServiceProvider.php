<?php


namespace EasyPanel;

use EasyPanel\Commands\{Actions\MakeCreate,
    Actions\MakeList,
    Actions\MakeSingle,
    Actions\MakeUpdate,
    CreateAll,
    DeleteAdmin,
    Install,
    MakeAdmin};
use EasyPanel\Http\Livewire\Todo\Create;
use EasyPanel\Http\Livewire\Todo\Lists;
use EasyPanel\Http\Livewire\Todo\Single;
use EasyPanel\Http\Middleware\isAdmin;
use EasyPanel\Support\Contract\{UserProviderFacade, AuthFacade};
use Illuminate\{Routing\Router, Support\Facades\File, Support\Facades\Route, Support\ServiceProvider, Support\Str};
use Livewire\Livewire;

class EasyPanelServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/easy_panel_config.php', 'easy_panel');
        $this->defineFacades();
        $this->bindCommands();
    }

    public function boot()
    {
        if(!$this->app->runningInConsole()) {
            $this->registerMiddlewareAlias();

            $this->loadViewsFrom(__DIR__ . '/../resources/views', 'admin');

            if (!$this->app->routesAreCached()) {
                $this->defineRoutes();
            }

            $this->loadLivewireComponent();
        }

        $this->mergePublishes();
    }

    private function defineRoutes()
    {
        $routeName = getRouteName();
        Route::prefix(config('easy_panel.route_prefix'))
            ->middleware(['web', 'auth', 'isAdmin'])
            ->name($routeName.'.')
            ->group(__DIR__ . '/routes.php');
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

        $this->publishes([__DIR__ . '/../resources/assets' => public_path('/assets/vendor/admin'), __DIR__ . '/../resources/dist' => public_path('/dist/vendor/admin')], 'easy-panel-styles');

        $this->publishes([__DIR__ . '/../database/migrations/2020_09_05_99999_create__todos_table.php' => base_path('/database/migrations/' . date('Y_m_d') . '_99999_create__admin_todos_table.php')], 'easy-panel-migrations');
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
