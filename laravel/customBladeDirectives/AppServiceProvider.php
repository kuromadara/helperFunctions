<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Custom Blade directive to convert numeric month to word
        \Blade::directive('monthToWord', function ($month) {
            return "<?php echo date('F', mktime(0, 0, 0, $month, 1)); ?>";
        });
    }

    // Rest of the class...
}
