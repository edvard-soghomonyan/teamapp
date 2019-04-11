<?php

namespace App\Providers;

use App\Repositories\Concretes\Api\V1\Teams\TeamsRepository;
use App\Repositories\Concretes\Api\V1\Users\UsersRepository;
use App\Repositories\Contracts\Api\V1\Teams\TeamsRepositoryInterface;
use App\Repositories\Contracts\Api\V1\Users\UsersRepositoryInterface;
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
        $this->app->bind(UsersRepositoryInterface::class, UsersRepository::class);
        $this->app->bind(TeamsRepositoryInterface::class, TeamsRepository::class);
    }
}
