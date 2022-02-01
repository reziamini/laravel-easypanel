<?php

namespace EasyPanel\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class LangManager
{
    public static function get()
    {
        $files = collect(File::glob(resource_path('lang/*_panel.json')));

        return $files->mapWithKeys(function ($file, $key){
            preg_match('/(\w+)_panel\.json/i', $file, $m);
            $key = "$m[1]_panel";
            $value = Str::upper($m[1]);
            return [$key => $value];
        })->toArray();
    }
}
