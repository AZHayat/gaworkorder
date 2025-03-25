<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            return redirect('/home')->with('error', 'Kamu belum login! yuk login dulu');
        }

        if (!in_array(Auth::user()->role, $roles)) {
            return redirect('/')->with('error', 'Kamu Hanya ' . ucfirst(Auth::user()->role) . ', yang bisa akses ini hanya admin');
        }

        return $next($request);
    }
}
