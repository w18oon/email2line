<?php

namespace App\Providers;

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
        View::share('menus', [
            ['slug' => 'groups', 'label' => 'Groups'],
            ['slug' => 'mappings', 'label' => 'Mappings'],
            ['slug' => 'reports', 'label' => 'Reports'],
            ['slug' => 'users', 'label' => 'Users'],
            ['slug' => 'gmail-auth', 'label' => 'Gmail Auth'],
        ]);
    }
}
