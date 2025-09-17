<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Validator::extend('less_than_field', function ($attribute, $value, $parameters, $validator) {
            // اسم الحقل التاني (المقارن)
            $other = $parameters[0] ?? null;
            $data = $validator->getData();
            $max  = $data[$other] ?? null;

            // الشرط: يا إما وحدة منن null أو min <= max
            return is_null($value) || is_null($max) || $value <= $max;
    }, 'The :attribute must be less than :other.');
    }
}
