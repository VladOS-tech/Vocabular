<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Phraseology extends Model
{
    use HasFactory;

    // Указываем таблицу, если имя таблицы не совпадает с именем модели
    protected $table = 'phraseologies';

    // Поля, которые могут быть массово присвоены
    protected $fillable = [
        'content',      // Содержимое фразеологизма
        'meaning',      // Значение фразеологизма
        'status',
    ];

    // Отношение с моделью User (модератором)
    public function moderator()
    {
        return $this->belongsTo(Moderator::class, 'moderator_id');
    }
    
    // Отношение с таблицей контекстов
    public function contexts()
    {
        return $this->hasMany(Context::class, 'phraseology_id');
    }

    // Отношение с тегами
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'phraseology_tag', 'phraseology_id', 'tag_id');
    }
}

