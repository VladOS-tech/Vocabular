<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class AuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->session()->has('user_id') || !$request->session()->has('role_id')) {
            return response()->json(['message' => 'Неавторизованный'], 401);
        }

        // Проверяем, существует ли пользователь
        $user = User::find($request->session()->get('user_id'));

        if (!$user) {
            return response()->json(['message' => 'Неверные данные сессии'], 401);
        }

        return $next($request);
    }
}

