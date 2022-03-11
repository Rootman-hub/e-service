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
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    // public const HOME = '/dashboard';
    public const HOME = '/index';
    // protected $namespace='App\Http\controllers';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });

        Route::model('article', App\Models\article::class);
        // Route::bind('article', function ($value, $route) {
        //     return $this->getModel(\App\Models\article::class, $value);
        // });
        // Route::bind('commander_tee_shirt', function ($value, $route) {
        //     return $this->getModel(\App\Models\commander_tee_shirt::class, $value);
        // });

    

    
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
    private function getModel($model, $routeKey)
    {
        $id = \Hashids::connection($model)->decode($routeKey)[0] ?? null;
        $modelInstance = resolve($model);
    
        return  $modelInstance->findOrFail($id);
    }
}