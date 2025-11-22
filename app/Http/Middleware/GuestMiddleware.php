<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GuestMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (session('logged_in')) {
            // Jika sudah login, redirect ke dashboard sesuai user type
            if (session('user_type') === 'standard') {
                return redirect()->route('home.standard');
            } else if (session('user_type') === 'advance') {
                return redirect()->route('home.advance');
            } else if (session('user_type') === 'admin') {
                return redirect()->route('admin.dashboard');
            }
        }

        return $next($request);
    }
}