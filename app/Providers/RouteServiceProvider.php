<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Определение основного пространства имен для маршрутов приложения.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Определение, где следует загружать маршруты для веб-приложения.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Регистрация маршрутов приложения.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    /**
     * Регистрация маршрутов для API.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }

    /**
     * Регистрация маршрутов для веб-приложения.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }
}
