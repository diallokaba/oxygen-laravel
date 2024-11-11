<?php

namespace App\Providers;

use App\Repositories\FavorisRepository;
use App\Repositories\IFavorisRepository;
use App\Repositories\ITransactionRepository;
use App\Repositories\IUserRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use App\Services\FavorisService;
use App\Services\IFavorisService;
use App\Services\ITransactionService;
use App\Services\IUserService;
use App\Services\TransactionService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(IUserRepository::class, UserRepository::class);
        $this->app->bind(IUserService::class, UserService::class);
        $this->app->bind(IFavorisRepository::class, FavorisRepository::class);
        $this->app->bind(IFavorisService::class, FavorisService::class);
        $this->app->bind(ITransactionRepository::class, TransactionRepository::class);
        $this->app->bind(ITransactionService::class, TransactionService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //Passport::loadKeysFrom(storage_path());
        //Passport::loadKeysFrom(__DIR__.'/../storage/oauth');

    }
}
