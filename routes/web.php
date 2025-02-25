<?php

use App\Http\Controllers\GameController;
use App\Http\Controllers\LinkController;
use App\Http\Middleware\CheckLink;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;



Route::get('/', [RegisteredUserController::class, 'create']);
Route::post('/', [RegisteredUserController::class, 'store'])->name('register');

Route::get('lucky-game/', [GameController::class, 'index'])->name('lucky.game')
    ->middleware('signed', CheckLink::class);
Route::get('link', [LinkController ::class, 'generateLink']);
Route::delete('link', [LinkController ::class, 'deactivateLink']);
Route::post('game', [GameController::class, 'runGame']);
