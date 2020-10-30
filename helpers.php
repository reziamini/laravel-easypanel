<?php

if(! function_exists('get_route_name'))
{
    function get_route_name(){
        $routeName = str_replace('/', '.', config('admin_panel.route_prefix'));
        return $routeName;
    }
}

if(! function_exists('get_icon'))
{
    function get_icon($type){
        $array = [
            'file-text' => ['posts', 'article', 'stories', 'post', 'articles', 'story']
        ];
        foreach ($array as $key => $arrayValues){
            if(in_array($type, $arrayValues)){
                $val = $key;
            }
        }
        return $val ?? 'grid';
    }
}
