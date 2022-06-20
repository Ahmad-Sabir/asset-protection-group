<?php

namespace App\Providers;

use App\Http\View\Composers\NotificationComposer;
use App\Http\View\Composers\NotificationCount;
use Illuminate\Support\Facades\View;
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

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('layouts.header', NotificationComposer::class);
        View::composer('layouts.header', NotificationCount::class);
    }
}
