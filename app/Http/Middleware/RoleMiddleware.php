<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if (!Auth::check()) {
            return redirect('/auth');
        }

        if (Auth::user()->role !== $role) {
            $dashboard = Auth::user()->role === 'admin' ? '/admin/dashboard' : '/peserta/dashboard';
            
            return redirect($dashboard)->with('error', 'Anda tidak memiliki akses ke halaman tersebut.');
        }

        return $next($request);
    }
}
