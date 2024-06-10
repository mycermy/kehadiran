<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //Public folder name changed with
        $this->app->bind('path.public', function () {
            //untuk linux base
            // return base_path() . '/../public_xxx';
            //untuk windows base
            // return base_path() . "\\..\\public_xxx";
            return base_path() . config('filesystems.publicHtml');
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
