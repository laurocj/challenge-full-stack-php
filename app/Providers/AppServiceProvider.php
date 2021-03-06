<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
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
        $this->loadBladeComponet();
    }


    private function loadBladeComponet()
    {
        Blade::include('includes.input', 'input');
        Blade::include('includes.check', 'check');
        Blade::include('includes.select', 'select');
        Blade::include('includes.destroy', 'destroy');
    }
}
