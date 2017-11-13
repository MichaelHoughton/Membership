<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class AdminOnly
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->user()) {
            return redirect('/login');
        }

        if ($request->user() && $request->user()->admin) {
            return $next($request);
        }

        abort(403, 'You are not authorized to access this page.');
    }
}
