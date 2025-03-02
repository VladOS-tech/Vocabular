<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicPhraseologyController;
use App\Http\Controllers\PublicTagController;
use App\Http\Controllers\AuthController;


Route::get('/phraseologies', [PublicPhraseologyController::class, 'index']);
Route::get('/phraseologies/{id}', [PublicPhraseologyController::class, 'show']);
Route::post('/phraseologies', [PublicPhraseologyController::class, 'store']);
Route::get('/tags', [PublicTagController::class, 'index']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
