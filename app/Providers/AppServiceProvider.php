<?php

namespace App\Providers;

use App\Repositories\User\{UserRepository, UserRepositoryImplement};
use App\Repositories\Product\{ProductRepository, ProductRepositoryImplement};
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepository::class, UserRepositoryImplement::class);
        $this->app->bind(ProductRepository::class, ProductRepositoryImplement::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
