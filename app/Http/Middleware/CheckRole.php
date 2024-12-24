<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $role)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login'); // Chưa đăng nhập
        }

        if (($role === 'manager' && !$user->is_quanly) || ($role === 'employee' && $user->is_quanly)) {
            return redirect('/unauthorized'); // Không có quyền
        }

        return $next($request);
    }
}
