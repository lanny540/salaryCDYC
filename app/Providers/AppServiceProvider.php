<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Carbon::setLocale('zh');

//        View::share('msgCount', 5);
        View::composer('*', 'App\Http\ViewComposers\MsgComposer');
    }

    /**
     * Register any application services.
     */
    public function register()
    {
        if ('production' !== $this->app->environment()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
