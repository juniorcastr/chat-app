<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
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
        if (extension_loaded('ddtrace')) {
            require __DIR__ . '/../../vendor/autoload.php';
        }

        Schema::defaultStringLength(191);
        if (function_exists('dd_trace')) {
            dd_trace('App\\Http\\Controllers\\ChatController@sendMessage', function ($args, $next) {
                $span = \DDTrace\GlobalTracer::get()->startSpan('send_message');
                $span->setTag('custom.tag', 'value');
                $result = $next($args);
                $span->finish();
                return $result;
            });
        }
    }
}
