<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    use HasFactory;

    protected $table = 'logins'; 

    protected $fillable = ['email', 'password'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function getAuthIdentifierName()
    {
        return 'email'; // email используется как идентификатор
    }

    public function getAuthIdentifier()
    {
        return $this->email; // идентификатор — это email
    }

    public function getAuthPassword()
    {
        return $this->password; // пароль для аутентификации
    }

    public function getRememberToken()
    {
        return $this->remember_token;
    }

    public function setRememberToken($value)
    {
        $this->remember_token = $value;
    }

    public function getRememberTokenName()
    {
        return 'remember_token';
    }
}
