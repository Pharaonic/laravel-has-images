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
        //
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
            __DIR__ . '/database/migrations/images.stub'         => database_path(sprintf('migrations/%s_create_images_table.php',          date('Y_m_d_His', time()))),
        ], ['pharaonic', 'laravel-has-images']);

        // Loads
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
    }
}
