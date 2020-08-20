<?php

namespace App\Providers;

use App\RegisteredClient;
use App\Observers\RegisteredClientObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function boot()
    {
        RegisteredClient::observe(RegisteredClientObserver::class);
    }
}
