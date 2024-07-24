<?php

namespace App\Providers;

use App\Http\Controllers\BuyController;
use App\Http\Controllers\ProductController;
use App\Repositories\ProductRepository;
use App\Repositories\RepositoryInterface;
use App\Services\BuyService;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->when(ProductController::class)
            ->needs(RepositoryInterface::class)
            ->give(function () {
                return new ProductRepository();
            });

        $this->app->when(BuyController::class)
            ->needs(RepositoryInterface::class)
            ->give(function () {
                return new ProductRepository();
            });

        $this->app->when(BuyService::class)
            ->needs(RepositoryInterface::class)
            ->give(function () {
                return new ProductRepository();
            });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
