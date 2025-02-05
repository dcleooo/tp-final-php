<?php

use App\Http\Controllers\SuperheroesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware("auth:api")->get("/user", function (Request $request) {
    return $request->user();
});

Route::get('/User',[SuperheroesController::class,'index']);
Route::get('/User/{id}',[SuperheroesController::class, 'show']);
Route::post('/User',[SuperheroesController::class,'store']);
Route::put('/User/{id}',[SuperheroesController::class,'update']);
Route::delete('/User/{id}',[SuperheroesController::class,'destroy']);

