<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Superadmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        $loggedUser = auth()->user();
        if($loggedUser->userType!=='superadmin')
            abort(401,'لاتملك الصلاحيات');
        return $next($request);
    }
}
