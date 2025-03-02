<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'name',  // Например: 'admin', 'moderator'
    ];

    public function users()
    {
        return $this->hasMany(User::class);  // Одна роль может быть связана с несколькими пользователями
    }
}
