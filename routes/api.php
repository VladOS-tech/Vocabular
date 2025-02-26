<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicPhraseologyController;

Route::get('/phraseologies', [PublicPhraseologyController::class, 'index']);
Route::get('/phraseologies/{id}', [PublicPhraseologyController::class, 'show']);
