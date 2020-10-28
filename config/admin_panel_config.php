<?php

return [

    // Enable the todo feature
    'todo' => true,
    'todo_model' => \App\Models\Todo::class,

    // How to authenticate admin
    // You may use other ways to authenticate a admin (tables or ..) you can manage it with this class
    'auth_class' => \AdminPanel\Support\Auth\ColumnAuth::class,

    // With this class you can manage how to create a admin or remove it.
    'admin_provider_class' => \AdminPanel\Support\User\UserProvider::class,

    // if You use a column in your users table to identify admins , put column name here
    'column' => 'is_superuser',

    // it's a place where a user if not authenticated will be redirected
    'redirect_unauthorized' => '/',

    // Admin panel routes prefix
    'route_prefix' => 'admin',


    // CRUD manager
    'actions' => [
        'user' => [
            'model' => \App\Models\User::class,
            'create' => true,
            'edit' => true,
            'delete' => true,
        ],
        'article' => [
            'model' => \App\Models\Article::class,
            'create' => true,
            'edit' => true,
            'delete' => true,
        ],
    ],
];
