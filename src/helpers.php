<?php

if(! function_exists('getRouteName'))
{
    function getRouteName(){
        $routeName = str_replace('/', '.', config('admin_panel.route_prefix'));
        return $routeName;
    }
}

if(! function_exists('get_icon'))
{
    function get_icon($type){
        $array = [
            'file-text' => ['posts', 'article', 'stories', 'post', 'articles', 'story'],
            'user' => ['users', 'user', 'accounts', 'account', 'admins', 'admin', 'employee', 'employees'],
            'file' => ['files', 'file'],
            'mic' => ['episode', 'episodes', 'voices', 'voice'],
        ];
        foreach ($array as $key => $arrayValues){
            if(in_array($type, $arrayValues)){
                $val = $key;
            }
        }
        return $val ?? 'grid';
    }
}
