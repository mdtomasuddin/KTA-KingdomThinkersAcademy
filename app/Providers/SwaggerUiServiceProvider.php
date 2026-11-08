<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class SwaggerUiServiceProvider extends ServiceProvider
{
    public function boot() : void
    {
        Gate::define('viewSwaggerUI', function ($user = null) {
            if (app()->environment('local')) {
                return true;
            }

            return in_array(optional($user)->email, [
                // Add allowed admin emails for production
            ]);
        });
    }
}
