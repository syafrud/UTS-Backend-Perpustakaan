<?php

namespace App\Modules\Circulation\Providers;

use Illuminate\Support\ServiceProvider;

class CirculationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'circulation');
    }
}
