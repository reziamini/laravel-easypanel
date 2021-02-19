<?php

return [

    // Enable whole module
    'enable' => true,

    // Enable the todo feature, it needs connection to db to run migration
    'todo' => false,

    // RTL Style , If you are using a language like Persian or Arabic change it true
    'rtl_mode' => false,

    // Package Language
    'lang' => 'en',

    // Your user Model
    'user_model' => file_exists(app_path('User.php')) ? App\User::class : App\Models\User::class,

    // How to authenticate admin
    // You may use other ways to authenticate a admin (tables or ..) you can manage it with this class
    'auth_class' => \EasyPanel\Support\Auth\ColumnAuth::class,

    // With this class you can manage how to create a admin or remove it.
    'admin_provider_class' => \EasyPanel\Support\User\UserProvider::class,

    // if You use a column in your users table to identify admins , put column name here
    'column' => 'is_superuser',

    // it's a place where a user if not authenticated will be redirected
    'redirect_unauthorized' => '/',

    // Admin panel routes prefix
    'route_prefix' => 'admin', //  http://localhost/admin

    // Count of pagination in CRUD lists
    'pagination_count' => 20,

    // Lazy validation for Livewire components
    'lazy_mode' => true,

    // enabled actions, If you want to create crud you must put action name here
    'actions' => [],
];
