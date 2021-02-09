<?php

if(! function_exists('getRouteName')) {
    function getRouteName(){
        $routeName = config('easy_panel.route_prefix');
        $routeName = trim($routeName, '/');
        $routeName = str_replace('/', '.', $routeName);
        return $routeName;
    }
}

if(! function_exists('get_icon')) {
    function get_icon($type){
        $array = [
            'file-text' => ['posts', 'article', 'stories', 'post', 'articles', 'story'],
            'users' => ['users', 'user', 'accounts', 'account', 'admins', 'admin', 'employee', 'employees'],
            'file' => ['files', 'file'],
            'mic' => ['episode', 'episodes', 'voices', 'voice'],
            'book' => ['book', 'books'],
            'tag' => ['tag', 'tags'],
            'bookmark' => ['bookmarks', 'bookmark'],
            'heart' => ['likes', 'like', 'favorite', 'favorites'],
            'music' => ['musics', 'music', 'audios', 'audio'],
            'bell' => ['notifications', 'notification'],
            'layers' => ['request', 'requests'],
            'settings' => ['settings', 'setting'],
            'truck' => ['product', 'products', 'shops', 'shop'],
            'message-circle' => ['comments', 'messages', 'pm', 'comment', 'message', 'chats', 'chat'],
        ];
        foreach ($array as $key => $arrayValues){
            if(in_array($type, $arrayValues)){
                $val = $key;
            }
        }
        return $val ?? 'grid';
    }
}

if(! function_exists('registerActionRoutes')){
    function registerActionRoutes($action, $component, $crudConfig)
    {
        Route::prefix($action)->name("$action.")->group(function () use ($component, $crudConfig, $action) {

            if(@class_exists("$component\\Read")) {
                Route::get('/', "$component\\Read")->name('read');
            }

            if (@$crudConfig['create'] and @class_exists("$component\\Create")) {
                Route::get('/create', "$component\\Create")->name('create');
            }

            if (@$crudConfig['update'] and @class_exists("$component\\Update")) {
                Route::get('/update/{' . $action . '}', "$component\\Update")->name('update');
            }

        });
    }
}
