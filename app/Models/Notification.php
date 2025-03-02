<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    // Указываем таблицу, если имя таблицы не совпадает с именем модели
    protected $table = 'notifications';

    // Поля, которые могут быть массово присвоены
    protected $fillable = [
        'moderator_id', // ID модератора
        'content',      // Содержание уведомления
        'is_read',      // Статус прочтения
    ];

    // Указываем, что это булевое значение
    protected $casts = [
        'is_read' => 'boolean',
    ];

    // Отношение с моделью Moderator
    public function moderator()
    {
        return $this->belongsTo(Moderator::class, 'moderator_id');
    }
}

