<?php


namespace EasyPanel;

use EasyPanel\Commands\{Actions\DeleteCRUD,
    Actions\Install,
    Actions\MakeCRUD,
    Actions\MakeCRUDConfig,
    Actions\Migration,
    Actions\PublishStubs,
    Actions\Reinstall,
    Actions\Uninstall,
    CRUDActions\MakeCreate,
    CRUDActions\MakeRead,
    CRUDActions\MakeSingle,
    CRUDActions\MakeUpdate,
    UserActions\DeleteAdmin,
    UserActions\GetAdmins,
    UserActions\MakeAdmin};
use EasyPanel\Http\Middleware\isAdmin;
use EasyPanel\Http\Middleware\LangChanger;
use EasyPanel\Models\PanelAdmin;
use EasyPanel\Support\Contract\{AuthFacade, LangManager, UserProviderFacade};
use EasyPanelTest\Dependencies\User;
use Exception;
use Illuminate\{Routing\Router,
    Support\Facades\Blade,
    Support\Facades\DB,
    Support\Facades\Log,
    Support\Facades\Route,
    Support\ServiceProvider};
use Livewire\Livewire;

class EasyPanelServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Here we merge config with 'easy_panel' key
        $this->mergeConfigFrom(__DIR__ . '/../config/easy_panel_config.php', 'easy_panel');

        // Check the status of module
        if (!config('easy_panel.enable')) {
            return;
        }

        // Facades will be set
        $this->defineFacades();
    }

    private function defineFacades()
    {
        AuthFacade::shouldProxyTo(config('easy_panel.auth_class'));
        UserProviderFacade::shouldProxyTo(config('easy_panel.admin_provider_class'));
        LangManager::shouldProxyTo(config('easy_panel.lang_manager_class'));
    }

    public function boot()
    {
        if (!config('easy_panel.enable')) {
            return;
        }

        // Here we register publishes and Commands
        $isRunningInConsole = $this->app->runningInConsole();
        if ($isRunningInConsole) {
            $this->mergePublishes();
        }

        // Bind Artisan commands
        $this->bindCommands();

        // Load Views with 'admin::' prefix
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'admin');

        // Register Middleware
        $this->registerMiddlewareAlias();

        // Load Livewire components
        $this->loadLivewireComponent();

        // check if database is connected to work with DB
        $isDBConnected = $this->isDBConnected();
        if ($isDBConnected) {
            // Define routes if doesn't cache
            $this->defineRoutes();
            // Load relationship for administrators
            $this->loadRelations();
        } else if ($isRunningInConsole) {
            echo "\033[31m ** Please check your DB connection \033[0m\n";
            echo "\033[31m ** Can not load routes of EasyPanel \033[0m\n";
        }

        Blade::componentNamespace("\\EasyPanel\\ViewComponents", 'easypanel');
    }

    private function mergePublishes()
    {
        $this->publishes([__DIR__ . '/../config/easy_panel_config.php' => config_path('easy_panel.php')], 'easy-panel-config');

        $this->publishes([__DIR__ . '/../resources/views' => resource_path('/views/vendor/admin')], 'easy-panel-views');

        $this->publishes([__DIR__ . '/../resources/assets' => public_path('/assets/admin')], 'easy-panel-styles');

        $this->publishes([
            __DIR__ . '/../database/migrations/cruds_table.php' => base_path('/database/migrations/' . date('Y_m_d') . '_999999_create_cruds_table_easypanel.php'),
            __DIR__ . '/../database/migrations/panel_admins_table.php' => base_path('/database/migrations/' . date('Y_m_d') . '_999999_create_panel_admins_table_easypanel.php'),
        ], 'easy-panel-migration');

        $this->publishes([__DIR__ . '/../resources/lang' => app()->langPath()], 'easy-panel-lang');

        $this->publishes([__DIR__ . '/Commands/stub' => base_path('/stubs/panel')], 'easy-panel-stubs');
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
            MakeCRUDConfig::class,
            GetAdmins::class,
            Migration::class,
            Uninstall::class,
            Reinstall::class,
            PublishStubs::class
        ]);
    }

    private function registerMiddlewareAlias()
    {
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('isAdmin', isAdmin::class);
        $router->aliasMiddleware('LangChanger', LangChanger::class);
    }

    private function loadLivewireComponent()
    {
        Livewire::component('admin::livewire.crud.single', Http\Livewire\CRUD\Single::class);
        Livewire::component('admin::livewire.crud.create', Http\Livewire\CRUD\Create::class);
        Livewire::component('admin::livewire.crud.lists', Http\Livewire\CRUD\Lists::class);

        Livewire::component('admin::livewire.translation.manage', Http\Livewire\Translation\Manage::class);

        Livewire::component('admin::livewire.role.single', Http\Livewire\Role\Single::class);
        Livewire::component('admin::livewire.role.create', Http\Livewire\Role\Create::class);
        Livewire::component('admin::livewire.role.update', Http\Livewire\Role\Update::class);
        Livewire::component('admin::livewire.role.lists', Http\Livewire\Role\Lists::class);

        Livewire::component('admin::livewire.admins.single', Http\Livewire\Admins\Single::class);
        Livewire::component('admin::livewire.admins.update', Http\Livewire\Admins\Update::class);
    }

    private function isDBConnected()
    {
        try {
            $connection = config('easy_panel.database.connection') ?: config('database.default');
            DB::connection($connection)->getPDO();
        } catch (Exception $e) {
            Log::error('Please check your DB connection \n  Can not load routes of EasyPanel');
            Log::error($e->getMessage());
            return false;
        }
        return true;

    }

    private function defineRoutes()
    {
        if (!$this->app->routesAreCached()) {
            $middlewares = array_merge(['web', 'isAdmin', 'LangChanger'], config('easy_panel.additional_middlewares'));

            Route::prefix(config('easy_panel.route_prefix'))
                ->middleware($middlewares)
                ->name(getRouteName() . '.')
                ->group(__DIR__ . '/routes.php');
        }
    }

    private function loadRelations()
    {
        $model = !$this->app->runningUnitTests() ? config('easy_panel.user_model') : User::class;

        $model::resolveRelationUsing('panelAdmin', function ($userModel) {
            return $userModel->hasOne(PanelAdmin::class)->latest();
        });
    }

}
