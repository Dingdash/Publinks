<?php

namespace App\Http\Middleware;

use Closure;

class CheckAdminSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!$request->session()->exists('admin')){

        return redirect('/admin');
     }
        return $next($request);
    }
}
