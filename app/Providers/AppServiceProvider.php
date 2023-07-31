<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\subMenu;
use App\Models\menus;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        $this->app->singleton('menu', function () {
            return menus::with('submenus')->get();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
