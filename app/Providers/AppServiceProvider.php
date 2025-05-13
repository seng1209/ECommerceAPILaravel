<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

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
        $this->confingLogin();

        $this->configApi();

        Schema::defaultStringLength(191);
    }

    protected function confingLogin()
    {
        RateLimiter::for('login', function (Request $request) {
            $key = $request->ip(); // or use $request->user()->id for user-specific limits

            if (RateLimiter::tooManyAttempts($key, 3)) {
                return response()->json([
                    'message' => 'Too many login attempts. Please try again in 5 minutes.'
                ], 429); // 429 Too Many Requests
            }

            // Increment attempts on failure
            RateLimiter::hit($key);

        });
    }

    protected function configApi()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60);
        });
    }

}
