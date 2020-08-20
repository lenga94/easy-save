<?php

namespace App\Providers;

use App\Client;
use App\Observers\ClientObserver;
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
        Client::observe(ClientObserver::class);
    }
}
