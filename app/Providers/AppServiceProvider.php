<?php

namespace App\Providers;

use App\Models\Tool;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
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
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }

        View::composer(
            ['layouts.partials.header', 'layouts.partials.footer'],
            function ($view): void {
                // Tool list rarely changes, so cache it for an hour to avoid
                // a query on every single page load. Clear the cache (or wait
                // an hour) after editing tools directly in the database.
                $view->with('navTools', Cache::remember(
                    'nav-tools',
                    3600,
                    fn () => Tool::active()->ordered()->get()
                ));
            }
        );
    }
}
