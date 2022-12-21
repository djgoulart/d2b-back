<?php

namespace App\Providers;

use App\Repositories\Eloquent\AccountRepositoryEloquent;
use App\Repositories\Eloquent\UserRepositoryEloquent;
use D2b\Domain\Customer\Repositories\AccountRepositoryInterface;
use D2b\Domain\Customer\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            UserRepositoryInterface::class,
            UserRepositoryEloquent::class,
        );

        $this->app->singleton(
            AccountRepositoryInterface::class,
            AccountRepositoryEloquent::class,
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
