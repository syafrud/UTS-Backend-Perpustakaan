<?php

namespace App\Modules\Catalog\Providers;

use App\Modules\Catalog\Contracts\BookCatalog;
use App\Modules\Catalog\Services\EloquentBookCatalog;
use Illuminate\Support\ServiceProvider;

class CatalogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Modul lain hanya boleh bergantung pada interface ini.
        $this->app->bind(BookCatalog::class, EloquentBookCatalog::class);
    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
        $this->loadRoutesFrom(__DIR__.'/../Routes/api.php');
        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'catalog');
    }
}
