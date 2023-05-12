<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

class CheckPermission
{
    public function handle($request, Closure $next, $guard = null)
    {
        if(auth()->check()){
            if(count($request->get('anyPermissionArray')) > 0 && !auth()->user()->anyPermissions($request->get('anyPermissionArray'))){
                whoops("Sorry! You are not authorize to visit the page!");
                return redirect('dashboard');
            }

            if(count($request->get('allPermissionArray')) > 0 && !auth()->user()->allPermissions($request->get('allPermissionArray'))){
                whoops("Sorry! You are not authorize to visit the page!");
                return redirect('dashboard');
            }
        }

    	return $next($request);
    }
}
