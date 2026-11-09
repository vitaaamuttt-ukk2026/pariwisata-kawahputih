<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
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
        // (PENGGABUNGAN) Saklar tema portal pengunjung. Jika VISITOR_THEME=a,
        // folder resources/themes/a dicari lebih dulu sehingga view tema A
        // menggantikan view bernama sama. Bawaan ('b') tidak mengubah apa pun.
        if (config('portal.visitor_theme') === 'a') {
            View::getFinder()->prependLocation(resource_path('themes/a'));
        }
    }
}
