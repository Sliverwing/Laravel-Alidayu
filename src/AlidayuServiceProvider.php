<?php

namespace Sliverwing\Alidayu;

use Illuminate\Support\ServiceProvider;

class AlidayuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $basePath = dirname(__DIR__);
        $this->publishes([
            $basePath . '/config/alidayu.php' => config_path('alidayu.php'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
