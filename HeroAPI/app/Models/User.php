<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Ramsey\Uuid\Guid\Guid;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    public $incrementing = false;
    protected $keyType = "string";
    protected $primaryKey = "UserId";
    protected $fillable = [
        'Name',
        "FirstName",
        'Email',
        'Password',
    ];
    protected $table = "users";
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (!$user->UserId) {
                $user->UserId = (string) Guid::uuid4();
            }
        });
    }

}
