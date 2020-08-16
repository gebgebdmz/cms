<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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

        //menghilangkan 2 angka dibelakang koma
        Blade::directive('currency', function ($expression) {
            return "<?php echo number_format($expression, 0, ',', '.'); ?>";
        });

        Blade::directive('discount', function ($expression) {
            return "<?php echo number_format($expression, 0, ',', '.'); ?>";
        });
    }
}
