<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    use HasFactory,HasApiTokens;
    protected $table = 'users';

    protected $fillable = [
        'name',
        'login_id',
        'role_id',
    ];

    public function login()
    {
        return $this->belongsTo(Login::class);  // Один пользователь связан с одним логином
    }

    public function role()
    {
        return $this->belongsTo(Role::class);  // Один пользователь имеет одну роль
    }

    public function isAdmin()
    {
        return $this->role_id === 1;  // Предположим, что роль администратора имеет ID 1
    }

    public function isModerator()
    {
        return $this->role_id === 2;  // Предположим, что роль модератора имеет ID 2
    }
}
