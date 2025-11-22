<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CustomAuthenticate
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('logged_in')) {
            return redirect()->route('login.index')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}