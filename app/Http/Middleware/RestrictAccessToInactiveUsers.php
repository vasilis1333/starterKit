<?php

namespace App\Http\Middleware;

use Closure;

class RestrictAccessToInactiveUsers
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
        if($request->user()->is_active == 0){
            abort('403','Ο λογαριασμός σας έχει απενεργοποιηθεί');
        }

        return $next($request);
    }
}
