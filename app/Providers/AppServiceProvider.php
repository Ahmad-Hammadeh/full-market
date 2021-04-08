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
        /**
         * Number Formatting And Add The Coin Sign For Blade Template Pages
         */
        Blade::directive('money', function ($amount) {

            return "<?php echo config('app.currency', '$') . app_number_format($amount); ?>";

        });
    }
}
