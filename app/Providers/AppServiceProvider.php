<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //  View::share('key', 'value');
        Schema::defaultStringLength(191);
        $url = 'https://backend.gronthik.com/public/';
        config(['rootUrl' => $url]);
    }
}
