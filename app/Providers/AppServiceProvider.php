<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use SocialiteProviders\Apple\AppleExtendSocialite;
use SocialiteProviders\Manager\SocialiteWasCalled;

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
        // Register Socialite Providers
        Event::listen(
            SocialiteWasCalled::class,
            [AppleExtendSocialite::class, 'handle']
        );

        // Super Admin and Admin have universal root access across all abilities
        Gate::before(function ($user, string $ability) {
            if ($user && in_array($user->role, ['super_admin', 'admin'], true)) {
                return true;
            }

            return null;
        });
    }
}
