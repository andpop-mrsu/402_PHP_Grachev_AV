<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;

Route::get('/', [GameController::class, 'index'])->name('game.index');
Route::get('/new', [GameController::class, 'create'])->name('game.create');
Route::post('/games', [GameController::class, 'store'])->name('game.store');
Route::get('/games/{game}', [GameController::class, 'show'])->name('game.show');
Route::get('/games/{game}/play', [GameController::class, 'play'])->name('game.play');
Route::post('/games/{game}/step', [GameController::class, 'makeStep'])->name('game.step');
