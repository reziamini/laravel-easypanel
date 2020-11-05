<?php


namespace AdminPanel\Http\Middleware;


use AdminPanel\Support\Contract\AuthFacade;
use Closure;

class isAdmin
{

    public function handle($request, Closure $next)
    {
        if(AuthFacade::checkIsAdmin(auth()->user()->id)){
            return $next($request);
        }

        return redirect(config('admin_panel.redirect_unauthorized'));
    }

}
