<?php

namespace App\Providers;

use App\Evertec\Evertec;
use Illuminate\Support\ServiceProvider;

class EvertecServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Evertec::class, function(){
            return new Evertec();
        });
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
