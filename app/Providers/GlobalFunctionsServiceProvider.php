<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;


class GlobalFunctionsServiceProvider extends ServiceProvider
{


    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function register()
    {
        require_once base_path().'/app/Helpers/GlobalFunctions.php';
    }
}
