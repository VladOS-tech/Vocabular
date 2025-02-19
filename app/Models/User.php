<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    // Указываем таблицу, если имя не совпадает
    protected $table = 'users';

    // Поля, доступные для массового заполнения
    protected $fillable = [
        'name',
        'password',
        'role_id',
    ];

    // Связь с ролью (многие к одному)
    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}

