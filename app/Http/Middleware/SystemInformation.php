<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Closure;

class SystemInformation
{
    public function handle($request, Closure $next, $guard = null)
    {
        if(!session()->has('system-information')){
            session()->put('system-information', systemInformation());
        }

    	return $next($request);
    }
}
