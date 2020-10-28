<?php


namespace AdminPanel;


use AdminPanel\Commands\DeleteAdmin;
use AdminPanel\Commands\Install;
use AdminPanel\Commands\MakeAdmin;
use AdminPanel\Http\Livewire\TODO\TodoSingle;
use AdminPanel\Http\Middleware\isAdmin;
use AdminPanel\Support\Contract\TodoFacade;
use AdminPanel\Support\Contract\UserProviderFacade;
use AdminPanel\Support\Contract\AuthFacade;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;

class AdminPanelServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/admin_panel_config.php', 'admin_panel');
        $this->defineFacades();
    }

    public function boot()
    {

        $this->registerMiddlewareAlias();

        $this->loadViewsFrom(__DIR__.'resources/view', 'admin');
        $this->loadLiveiwreComponent();

        if(!$this->app->routesAreCached()) {
            $this->defineRoutes();
        }

        $this->publishes([
            __DIR__.'/config/admin_panel_config.php' => config_path('admin_panel.php')
        ], 'admin-panel-config');

        $this->publishes([
            __DIR__.'/resources/view' => resource_path('/views/vendor/admin')
        ], 'admin-panel-views');

        $this->publishes([
            __DIR__.'/resources/assets' => public_path('/assets/vendor/admin'),
            __DIR__.'/resources/dist' => public_path('/dist/vendor/admin')
        ], 'admin-panel-styles');

        $this->publishes([
            __DIR__.'/database/migrations/2020_10_27_115952_create_todos_table.php' => base_path('/database/migrations/2020_10_27_115952_create_todos_table.php')
        ], 'admin-panel-migrations');

        $this->commands([
            MakeAdmin::class,
            DeleteAdmin::class,
            Install::class
        ]);

    }

    private function defineRoutes()
    {
        $routeName = str_replace('/', '.', config('admin_panel.route_prefix'));
        Route::prefix(config('admin_panel.route_prefix'))
            ->middleware(['web', 'auth', isAdmin::class])
            ->name($routeName.'.')
            ->group(__DIR__ . '/routes.php');
    }

    private function defineFacades()
    {
        /*if(!$this->app->runningUnitTests()){
            AuthFacade::shouldProxyTo(config('admin_panel.auth_class'));
            UserProviderFacade::shouldProxyTo(config('admin_panel.admin_provider_class'));
        } else {
            AuthFacade::shouldProxyTo(TestModeAuth::class);
            UserProviderFacade::shouldProxyTo(TestModeUserProvider::class);
        }*/
        AuthFacade::shouldProxyTo(config('admin_panel.auth_class'));
        UserProviderFacade::shouldProxyTo(config('admin_panel.admin_provider_class'));
        TodoFacade::shouldProxyTo(config('admin_panel.todo_model'));
    }

    private function registerMiddlewareAlias()
    {
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('isAdmin', isAdmin::class);
    }

    private function loadLiveiwreComponent()
    {
        Livewire::component('todo-single', TodoSingle::class);
    }

}
