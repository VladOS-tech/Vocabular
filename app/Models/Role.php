<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // Указываем таблицу, связанную с этой моделью
    protected $table = 'roles';

    // Разрешённые для массового заполнения поля
    protected $fillable = ['name'];

    /**
     * Связь с пользователями (один ко многим).
     */
    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}

