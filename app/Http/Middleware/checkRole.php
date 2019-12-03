<?php

namespace App\Http\Middleware;

use Closure;

class checkRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role='investor')
    {   
        if(!auth()->check()) return redirect()->route('login');

        $userRole = auth()->user()->role;
        if(strtolower($userRole)!=strtolower($role)){
            return abort(401);
        }
        return $next($request);
    }
}
