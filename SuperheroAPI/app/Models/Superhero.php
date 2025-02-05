<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Superhero extends Model
{
    use HasFactory;
    protected $table = 'SuperHeroes';
    protected $fillable = ['real_name', 'hero_name', 'gender', 'planet', 'description', 'city', 'team', 'vehicle'];

    public function powers()
    {
        return $this->belongsToMany(Power::class);
    }
}

