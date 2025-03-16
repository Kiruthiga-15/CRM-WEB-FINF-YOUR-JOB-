<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class Authenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        if (!$request->expectsJson()) {
        return route('admin.login'); // Ensure admin is redirected to login if not authenticated
        }

        return null;
    }
    public function handle($request, Closure $next, ...$guards)
{
    if (Auth::guard()->guest()) {
        return redirect('/login'); // Redirect if not logged in
    }

    return $next($request);
}
}
