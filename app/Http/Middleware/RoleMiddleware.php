<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        // Jika belum login → redirect ke home
        if (!$user) {
            return redirect('/');
        }

        // Jika role tidak sesuai → redirect berdasarkan role sebenarnya
        if ($user->role !== $role) {
            return match ($user->role) {
                'admin' => redirect('/admin/dashboard'),
                'operator' => redirect('/operator/lendings'),
                'staff' => redirect('/staff/dashboard'),
                default => redirect('/'),
            };
        }

        return $next($request);
    }
}