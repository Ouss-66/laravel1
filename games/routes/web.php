<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('games', [GameController::class, 'index']);
Route::get('games/create', [GameController::class, 'create']);
Route::post('games/store', [GameController::class, 'store']);