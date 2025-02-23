<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\PublicPhraseologyController;
use App\Http\Controllers\ModeratorPhraseologyController;
use App\Http\Controllers\AdminModeratorController;

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



    // Публичные маршруты (доступны всем пользователям)
    Route::get('/phraseologies', [PublicPhraseologyController::class, 'index']); // Список фразеологизмов
    Route::get('/phraseologies/search', [PublicPhraseologyController::class, 'search']); // Поиск
    Route::post('/phraseologies', [PublicPhraseologyController::class, 'store']); // Добавление нового фразеологизма


    // Маршруты для модераторов (требуется аутентификация)
Route::middleware(['auth:moderator'])->prefix('moderator')->group(function () {
    Route::get('/phraseologies', [ModeratorPhraseologyController::class, 'index']); // Список на модерацию
    Route::put('/phraseologies/{id}/approve', [ModeratorPhraseologyController::class, 'approve']); // Одобрить фразеологизм
    Route::put('/phraseologies/{id}/reject', [ModeratorPhraseologyController::class, 'reject']); // Отклонить фразеологизм
    Route::put('/phraseologies/{id}/tags', [ModeratorPhraseologyController::class, 'updateTags']); // Обновить теги
});



    // Маршруты для администраторов (требуется аутентификация)
Route::middleware(['auth:admin'])->prefix('admin')->group(function () {
    // Управление модераторами
    Route::get('/moderators', [AdminModeratorController::class, 'index']);
    Route::post('/moderators', [AdminModeratorController::class, 'store']);
    Route::put('/moderators/{id}', [AdminModeratorController::class, 'update']);
    Route::delete('/moderators/{id}', [AdminModeratorController::class, 'destroy']);
});
    /*
    Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:moderator'])->group(function () {
        Route::resource('moderator/phraseologies', ModeratorPhraseologyController::class);
    });

    Route::middleware(['role:admin'])->group(function () {
        Route::resource('admin/phraseologies', AdminPhraseologyController::class);
    });
});
    */
    



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
    
// Route::get('/', [PhraseologyController::class, 'index']);

    

// Route::post('/phraseologies', [PhraseologyController::class, 'store'])->name('phraseologies.store');


