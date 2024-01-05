<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AuthenticateApi extends Middleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$guards
     * @return mixed
     */
    public function handle($request, Closure $next, ...$guards)
    {
        if ($this->authenticate($request, $guards)) {
            return $next($request);
        }

        // Customize the JSON response for unauthenticated users
        return response()->json([
            'message' => 'Unauthorized. Please log in.',
        ], 401);
    }
}
