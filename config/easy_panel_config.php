<?php

return [

    // Enable the todo feature
    // it needs connection to db to run migration
    'todo' => true,

    // Your user Model
    'user_model' => App\Models\User::class,

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
    'route_prefix' => 'admin',

    // Count of pagination in CRUD lists
    'pagination_count' => 20,

    // CRUD manager
    'actions' => [
        // must be equals with your model name but with lower case words
        /*'article' => [
            'model' => \App\Models\Article::class,
            // searchable field, if you dont want search feature, remove it
            'search' => 'title',
            'create' => true,
            'update' => true,
            'delete' => true,
            'validation' => [
                'title' => 'required',
                'content' => 'required|min:30',
            ],
            // Write every fields in your db which you want to show
            'fields' => [
                'title' => 'text',
                'content' => 'textarea',
            ],
        ],*/
    ],
];
