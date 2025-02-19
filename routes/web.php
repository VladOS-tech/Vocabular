<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PhraseologyController;
use App\Http\Controllers\ModeratorController;
use App\Http\Controllers\ContextController;

// Главная страница
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Авторизация и доступ к панели управления
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Панель управления
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    // Фразеологизмы
    Route::resource('phraseologies', PhraseologyController::class)->only([
        'index', 'show', 'store', 'update', 'destroy',
    ]);
    
    
    



    // Контексты
    /*Route::resource('contexts', ContextController::class)->only([
        'store', 'update', 'destroy',
    ]);

    // Модераторы
    Route::get('/moderators', [ModeratorController::class, 'index'])->name('moderators.index');*/
});

/*Route::get('/', function () {
        return view('main');
    });*/
    
Route::get('/', [PhraseologyController::class, 'index']);

    

Route::post('/phraseologies', [PhraseologyController::class, 'store'])->name('phraseologies.store');


