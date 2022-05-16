<?php

namespace App\Providers;

use App\Interfaces\ModelResourceInterface;
use App\Interfaces\ProductInterface;
use Illuminate\Support\ServiceProvider;

use App\Interfaces\UserInterface;
use App\Repositories\ModelResourceRepository;
use App\Repositories\ProductRepository;
use App\Repositories\UserRepository;


class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Register Dependency Container
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(ProductInterface::class, ProductRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    public function provides()
    {
        // only called when this service provied is needed
        return [
            UserInterface::class,
            UserRepository::class,
            ProductInterface::class,
            ProductRepository::class
        ];
    }
}
