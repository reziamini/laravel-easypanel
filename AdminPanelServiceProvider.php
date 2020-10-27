<?php


namespace AdminPanel;


use AdminPanel\Commands\DeleteAdmin;
use AdminPanel\Commands\MakeAdmin;
use AdminPanel\Http\Middleware\isAdmin;
use AdminPanel\Support\Contract\UserProviderFacade;
use AdminPanel\Support\Contract\AuthFacade;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AdminPanelServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/admin_panel_config.php', 'admin_panel');
        $this->defineFacades();
    }

    public function boot()
    {
        if(!$this->app->routesAreCached()) {
            $this->defineRoutes();
        }
        $this->registerMiddlewareAlias();

        $this->loadViewsFrom(__DIR__.'resources/view', 'admin');

        $this->publishes([
            __DIR__.'/config/admin_panel_config.php'
        ], 'config');

        $this->commands([
            MakeAdmin::class,
            DeleteAdmin::class
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
    }

    private function registerMiddlewareAlias()
    {
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('isAdmin', isAdmin::class);
    }

}
