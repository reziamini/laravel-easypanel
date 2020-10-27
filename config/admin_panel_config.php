<?php

return [

    'auth_class' => \AdminPanel\Support\Auth\ColumnAuth::class,
    'admin_provider_class' => \AdminPanel\Support\User\UserProvider::class,
    'column' => 'is_superuser',

    'redirect_unauthorized' => '/',

    'route_prefix' => 'admin',

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
