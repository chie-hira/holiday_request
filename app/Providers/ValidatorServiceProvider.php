<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class ValidatorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    
    public function boot()
    {
        // // ひらがな
        // Validator::extend('hours', function ($attribute, $value, $parameters, $validator) {
            
        //     return $value % 0.125;
        // });
    }
}
