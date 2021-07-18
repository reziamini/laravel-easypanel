<?php

use EasyPanel\Contracts\CRUDComponent;

if(! function_exists('getRouteName')) {
    function getRouteName(){
        $routeName = config('easy_panel.route_prefix');
        $routeName = trim($routeName, '/');
        $routeName = str_replace('/', '.', $routeName);
        return $routeName;
    }
}

if(! function_exists('getCrudConfig')) {
    function getCrudConfig($name){
        $namespace = "\\App\\CRUD\\{$name}Component";

        if (!class_exists($namespace)){
            abort(403, "Class with {$namespace} namespace doesn't exist");
        }

        $instance = app()->make($namespace);

        if (!$instance instanceof CRUDComponent){
            abort(403, "{$namespace} should implement CRUDComponent interface");
        }

        return $instance;
    }
}

if(! function_exists('crud')) {
    function crud($name){
        return \EasyPanel\Models\CRUD::query()->where('name', $name)->first();
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
