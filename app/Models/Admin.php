<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    // Указываем, что основной ключ у нас - user_id, а не стандартный id
    protected $primaryKey = 'user_id';

    // Указываем таблицу, если имя таблицы не совпадает с именем модели
    protected $table = 'admins';

    // Поля, которые могут быть массово присвоены
    protected $fillable = [
        'user_id', // ID пользователя, который является администратором
        'email',    // Почта администратора
    ];

    // Связь с моделью User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

