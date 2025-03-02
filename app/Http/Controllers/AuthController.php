<?php

namespace App\Http\Controllers;

use App\Models\Login;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;




class AuthController extends Controller
{
    use HasApiTokens, Notifiable;
    /**
     * Логика авторизации пользователя
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $login = Login::where('email', $request->email)->first();

        Log::info('Вход в систему', [
            'email' => $request->email,
            'пароль из запроса' => $request->password,
            'пароль в базе' => $login->password
        ]);

        if (!$login || !Hash::check($request->password, $login->password)) {
            return response()->json(['message' => 'Неверный логин или пароль'], 401);
        }

        // Получаем всех пользователей, привязанных к этому логину
        $users = $login->users;

        if ($users->count() > 1) {
            // Если несколько пользователей, отправляем список ролей
            return response()->json([
                'message' => 'Выберите роль',
                'roles' => $users->map(fn($user) => [
                    'user_id' => $user->id,
                    'role_id' => $user->role_id,
                    'role_name' => $user->role->name,
                ]),
            ]);
        }

        // Если только одна роль, сразу авторизуем
        $user = $users->first();
        
        // Сохраняем данные в сессии
        Session::put('login_id', $login->id);
        Session::put('user_id', $user->id);
        Session::put('role_id', $user->role_id);

        return response()->json([
            'message' => 'Авторизация успешна',
            'user_id' => $user->id,
            'role' => $user->role->name,
        ]);
    }

    /**
     * Выбор роли для пользователя
     */
    public function selectRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::find($request->user_id);

        if (!$user) {
            return response()->json(['message' => 'Пользователь не найден'], 404);
        }

        // Сохраняем выбор в сессии
        Session::put('user_id', $user->id);
        Session::put('role_id', $user->role_id);

        return response()->json([
            'message' => 'Роль выбрана успешно',
            'role' => $user->role->name,
        ]);
    }


    /**
     * Логика выхода из системы
     */
    public function logout()
    {
        Session::forget('login_id');
        return response()->json(['message' => 'Вы вышли из системы']);
    }
}
