<?php

namespace App\Providers;

use App\Helpers\Result;
use App\Http\Controllers\BuyController;
use App\Http\Controllers\ProductController;
use App\Repositories\ProductRepository;
use App\Repositories\RepositoryInterface;
use App\Services\BuyService;
use App\Services\BuyServiceInterface;
use Illuminate\Support\ServiceProvider;

class ServiceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->when(BuyController::class)
            ->needs(BuyServiceInterface::class)
            ->give(function () {
                return new BuyService(new ProductRepository(), new Result());
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
