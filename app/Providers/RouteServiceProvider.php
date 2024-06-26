<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(300)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware(['api', 'auth:sanctum', 'type.user'])
                ->prefix('api_mobile/v01')
                ->group(base_path('routes/mobile/auth.php'));

            Route::middleware('api')
                ->prefix('api_mobile/v01')
                ->group(base_path('routes/mobile/no_auth.php'));

            Route::middleware(['api', 'auth:sanctum', 'type.admin'])
                ->prefix('api_admin/v01')
                ->group(base_path('routes/admin/auth.php'));

            Route::middleware(['api'])
                ->prefix('api_admin/v01')
                ->group(base_path('routes/admin/no_auth.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

}
