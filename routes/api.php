<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicPhraseologyController;
use App\Http\Controllers\PublicTagController;
use App\Http\Controllers\AuthController;


Route::get('/phraseologies', [PublicPhraseologyController::class, 'index']);
//Route::get('/phraseologies/{id}', [PublicPhraseologyController::class, 'show']);
Route::post('/phraseologies', [PublicPhraseologyController::class, 'store']);
Route::get('/tags', [PublicTagController::class, 'index']);
Route::get('/phraseologies/search', [PublicPhraseologyController::class, 'searchByContent']);
Route::get('/phraseologies/filter', [PublicPhraseologyController::class, 'filterByTags']);

Route::post('/login', [AuthController::class, 'login']);
Route::middleware(['auth.session'])->group(function () {
    Route::get('/phraseologies', [PublicPhraseologyController::class, 'index']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

