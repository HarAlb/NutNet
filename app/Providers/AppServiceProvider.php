<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use View;
use App\Track;
use Illuminate\Support\Facades\Cache;
use App\testHelper\Helper;
use Prophecy\Call\Call;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        view()->composer('*' , function ($view) {
            if( !Cache::has('tracks') ){
                Helper::cache_tracks();
            }

        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}
