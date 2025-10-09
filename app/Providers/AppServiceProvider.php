<?php

namespace App\Providers;

use App\Application\ListingService;
use App\Repository\ListingEloquentRepo;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ListingService::class,
            fn($app) => new ListingService($app->make(ListingEloquentRepo::class))
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
