<?php

use EasyPanel\Services\LangService;
use EasyPanel\Support\Auth\AdminIdentifier;
use EasyPanel\Support\User\UserProvider;

return [

    // Enable whole module
    'enable' => true,

    // RTL Style , If you are using a language like Persian or Arabic change it true
    'rtl_mode' => false,

    // Package Language
    'lang' => 'en',

    // Your user Model
    'user_model' => file_exists(app_path('User.php')) ? App\User::class : App\Models\User::class,

    // set default guard to authenticate admins
    'auth_guard' => config('auth.defaults.guard') ?? 'web',

    // How to authenticate admin
    // You may use other ways to authenticate a admin (tables or ..) you can manage it with this class
    'auth_class' => AdminIdentifier::class,

    // With this class you can manage how to create a admin or remove it.
    'admin_provider_class' => UserProvider::class,

    //The namespace of lang manager class
    'lang_manager_class' => LangService::class,

    // it's a place where a user if not authenticated will be redirected
    'redirect_unauthorized' => '/',

    // Admin panel routes prefix
    'route_prefix' => 'admin', //  http://localhost/admin

    // Your own middlewares for easy panel routes.
    'additional_middlewares' => [],

    // Count of pagination in CRUD lists
    'pagination_count' => 20,

    // Lazy validation for Livewire components
    'lazy_mode' => true,

    // database configure
    'database' => [
        'connection' => env('EASY_PANEL_DB_CONNECTION', env('DB_CONNECTION', 'mysql')),
        'panel_admin_table' => 'panel_admins',
        'crud_table' => 'cruds'
    ]
];
