<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HeroController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;

Route::middleware('api')->group(function () {
    Route::get("/heroes",[HeroController::class,"index"]);
    Route::get("/heroes/{id}",[HeroController::class,"show"]);
    Route::post("/heroes/create",[HeroController::class,"store"]);
    Route::put("/heroes/update",[HeroController::class,"update"]);
    Route::delete("/heroes/delete/{id}",[HeroController::class,"destroy"]);
    Route::get("/users",[UserController::class,"index"]);
    Route::post("/users/register",[UserController::class,"register"]);
    Route::post("/users/connection",[UserController::class,"connection"]);
    Route::put("/users/update",[UserController::class,"modify"]);
    Route::delete("/users/delete/{id}",[UserController::class,"destroy"]);
});