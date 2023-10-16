<?php

namespace App\Providers;

use DateTime;
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

        Validator::extend('sameMonth', function (
            $attribute,
            $value,
            $parameters,
            $validator
        ) {
            $startDate = $validator->getData()[$parameters[0]];
            return (new DateTime($startDate))->format('Y-m') ===
                (new DateTime($value))->format('Y-m');
        });

        Validator::replacer('sameMonth', function (
            $message,
            $attribute,
            $rule,
            $parameters
        ) {
            return __('validation.custom.sameMonth');
        });

        // 今日以外はNG
        Validator::extend('today', function (
            $attribute,
            $value,
            $parameters,
            $validator
        ) {
            return $value === now()->format('Y-m-d');
        });

        Validator::replacer('today', function (
            $message,
            $attribute,
            $rule,
            $parameters
        ) {
            return __('validation.custom.today');
        });
    }
}
