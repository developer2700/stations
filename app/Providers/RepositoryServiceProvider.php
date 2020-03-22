<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use App\Repositories\Interfaces\CompanyRepositoryInterface;
use App\Repositories\Interfaces\StationRepositoryInterface;
use App\Repositories\Eloquent\CompanyRepository;
use App\Repositories\Eloquent\StationRepository;
use App\Repositories\Eloquent\BaseRepository;
class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(EloquentRepositoryInterface::class, BaseRepository::class);
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->bind(StationRepositoryInterface::class, StationRepository::class);
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
}
