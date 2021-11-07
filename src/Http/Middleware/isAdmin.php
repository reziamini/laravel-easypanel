<?php

namespace EasyPanel\Http\Middleware;

use EasyPanel\Support\Contract\AuthFacade;
use Closure;

class isAdmin
{

    public function handle($request, Closure $next)
    {
        auth()->shouldUse(config('easy_panel.auth_guard'));

        if(auth()->guest()){
            return redirect(config('easy_panel.redirect_unauthorized'));
        }

        if(!AuthFacade::checkIsAdmin(auth()->user()->id)){
            return redirect(config('easy_panel.redirect_unauthorized'));
        }

        return $next($request);
    }

}
