<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use Ramsey\Uuid\Guid\Guid;

class Hero extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $keyType = "string";
    protected $primaryKey = "HeroId";
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($hero) {
            if (!$hero->HeroId) {
                $hero->HeroId = (string) Guid::uuid4();
            }
        });
    }
    protected $table = "heroes";

    protected $fillable = ["HeroId",'Name', 'Sex', 'OriginPlanet',
    'Description', 'Powers', 'Town', 'Gadgets', 'Team', 'Vehicule',"UserId"];

    protected $appends = ["UserName"];

    public function getUserNameAttribute()
    {
        $user = User::find($this->UserId);
        return $user ? $user->FirstName : "Inconnu";
    }
}
