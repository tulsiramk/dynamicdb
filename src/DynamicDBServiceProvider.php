<?php

namespace Tulsiramk\DynamicDB;

use Illuminate\Support\ServiceProvider;

class DynamicDBServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->make('Tulsiramk\DynamicDB\DynamicDBController');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
