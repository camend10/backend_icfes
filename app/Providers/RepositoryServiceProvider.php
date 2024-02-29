<?php

namespace App\Providers;

use App\Interfaces\UserRepository;
use App\Repositories\UserRepositoryImpl;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->bind(UserRepository::class, UserRepositoryImpl::class);
    }
}
