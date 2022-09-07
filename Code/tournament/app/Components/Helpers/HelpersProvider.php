<?php

namespace App\Components\Helpers;

use App\Components\Helpers\Helpers;
use Illuminate\Support\ServiceProvider;

class HelpersProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('helpers', function($app) {
            return new Helpers;
        });
    }
}
