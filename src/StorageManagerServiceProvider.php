<?php

namespace MostafaRDE\StorageManager;

use Carbon\Laravel\ServiceProvider;

class StorageManagerServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/mostafarde_storage_manager.php', 'mostafarde_storage_manager');
        $this->app->singleton('mostafarde-storage-manager', function()
        {
            return new StorageManager();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}