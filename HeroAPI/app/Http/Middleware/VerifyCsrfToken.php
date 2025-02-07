<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    protected $except = [
        '/books', // Permet les requêtes POST sans CSRF
        '/books/*', // Permet les requêtes PUT et DELETE sans CSRF
    ];
}