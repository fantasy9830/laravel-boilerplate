<?php

namespace App\Http\Middleware;

use Closure;

class ApiDoc
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
        if (config('app.env') === 'production') {
            abort(404);
        }

        return $next($request);
    }
}
