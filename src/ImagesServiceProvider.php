<?php

namespace Pharaonic\Laravel\Images;

use Illuminate\Support\ServiceProvider;

class ImagesServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Migrations Loading
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Publishes
        $this->publishes([
            __DIR__ . '/database/migrations/2021_02_01_000004_create_images_table.php' => database_path('migrations/2021_02_01_000004_create_images_table.php'),
        ], ['pharaonic', 'laravel-has-images']);
    }
}
