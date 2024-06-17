<?php

namespace App\Providers;

use App\Models\CompanySetting;
use App\Models\PayrollSetting;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use View;

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
        Schema::defaultStringLength(191);
        $settings = CompanySetting::find(1);
        define('SITE_URL','https://hrpro.pocketstudionepal.com/');
        View::share('settings', $settings);
    }
}
