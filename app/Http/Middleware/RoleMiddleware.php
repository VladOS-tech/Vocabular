<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        $role_id = $request->session()->get('role_id');

        if (!$role_id) {
            return response()->json(['message' => 'Неавторизованный'], 401);
        }

        // Проверяем роль
        if (($role === 'admin' && $role_id != 1) || ($role === 'moderator' && $role_id != 2)) {
            return response()->json(['message' => 'Доступ запрещен'], 403);
        }

        return $next($request);
    }
}

