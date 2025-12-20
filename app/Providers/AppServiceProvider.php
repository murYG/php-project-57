<?php

namespace App\Providers;

use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
    public function boot(UrlGenerator $url): void
    {
        //
        if (env('APP_ENV') == 'production') {
            $url->forceScheme('https');
        }

        Gate::define('destroy-task', function (\App\Models\User $user, \App\Models\Task $task) {
            return $user->id === $task->created_by_id;
        });
    }
}
