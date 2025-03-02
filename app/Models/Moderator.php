<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moderator extends Model
{
    use HasFactory;

    // Указываем, что модель связана с таблицей "moderators"
    protected $table = 'moderators';

    // Поля, доступные для массового заполнения
    protected $fillable = ['user_id', 'contact', 'online_status'];

    /**
     * Связь с пользователем (User).
     * Один модератор принадлежит одному пользователю.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}

