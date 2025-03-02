<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Context extends Model
{
    use HasFactory;

    // Указываем таблицу, если имя таблицы не совпадает с именем модели
    protected $table = 'contexts';

    // Поля, которые могут быть массово присвоены
    protected $fillable = [
        'phraseology_id', // ID фразеологизма
        'content',         // Контекст фразеологизма
    ];

    // Отношение с моделью Phraseology
    public function phraseology()
    {
        return $this->belongsTo(Phraseology::class, 'phraseology_id');
    }
}

