<?php

namespace App\Providers;

use App\Interfaces\GatewayInterface;
use Illuminate\Support\ServiceProvider;

class GatewayServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(GatewayInterface::class, function ($app) {
            return $app->request->route('payment')->provider->gateway();
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
