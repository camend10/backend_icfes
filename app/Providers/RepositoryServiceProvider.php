<?php

namespace App\Providers;

use App\Interfaces\UserRepository;
use App\Interfaces\RoleRepository;
use App\Interfaces\GeneralRepository;

use App\Repositories\UserRepositoryImpl;
use App\Repositories\RoleRepositoryImpl;
use App\Repositories\GeneralRepositoryImpl;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    // public function register(): void
    // {
    //     //
    // }

    /**
     * Bootstrap services.
     */
    // public function boot(): void
    // {
    //     $this->app->bind(
    //         UserRepository::class,
    //         RoleRepository::class,
    //         UserRepositoryImpl::class,
    //         RoleRepositoryImpl::class,
    //     );
    // }

        /**
     * All of the container bindings that should be registered.
     */
    public $bindings = [
        UserRepository::class => UserRepositoryImpl::class,
        RoleRepository::class => RoleRepositoryImpl::class,
        GeneralRepository::class => GeneralRepositoryImpl::class,
    ];
    /**
     * All of the container singletons that should be registered.
     */
    // public $singletons = [
    //     SomeService::class => SomeImplementService::class,
    // ];
}
