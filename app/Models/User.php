<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'users';
    protected $guard = 'user';
    protected $fillable = ['name', 'email', 'otp', 'otp_created_at', 'password'];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function tasks()
    {
        return $this->belongsToMany(Task::class, 'task_id', 'user_id');
    }

    public function comment()
    {
        return $this->hasMany(Comment::class, 'user_id', 'id');
    }
}
