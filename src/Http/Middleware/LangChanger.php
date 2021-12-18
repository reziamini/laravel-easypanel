<?php

namespace EasyPanel\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class LangChanger
{

    public function handle($request, Closure $next)
    {
        $lang = config('easy_panel.lang') ?? 'en';
        
        // vorja: let use a session to change language.
        $lang = !empty('easy_panel.lang') ? session('easy_panel.lang') : $lang;
        
        $langFormat = $lang.'_panel';

        App::setLocale($langFormat);

        return $next($request);
    }

}
