<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Laravel generates fully-qualified URLs for some reason, but because
        // we're behind two proxies that may or may not be setting headers
        // right, or using the right protocols, we try to force it to do the
        // correct thing instead of whatever inane thing it thinks is right.
        URL::forceRootUrl(config('app.url'));
        URL::forceScheme(env('FORCE_HTTPS', false) ? 'https' : 'http');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
