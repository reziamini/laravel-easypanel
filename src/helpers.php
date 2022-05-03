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

        if (!file_exists(app_path("/CRUD/{$name}Component.php")) or !class_exists($namespace)){
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
