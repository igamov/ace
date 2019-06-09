<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Blade;
Use Jenssegers\Date\Date;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
      Blade::directive('double', function($expression) {
        return "<?php echo number_format($expression, 2, ',', ' '); ?>";
      });
      Date::setlocale(config('app.locale'));
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }


}
