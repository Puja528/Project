<?php

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StandardMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login.index')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        if (Auth::user()->type !== 'standard') {

            if (Auth::user()->type === 'advance') {
                return redirect()->route('home.advance');
            }
            if (Auth::user()->type === 'admin') {
                return redirect()->route('admin.dashboard');
            }

            return redirect()->route('login.index')
                ->with('error', 'Tipe user tidak valid.');
        }

        return $next($request);
    }
}