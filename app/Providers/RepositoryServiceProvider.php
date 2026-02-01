<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\LearnerRepositoryInterface;
use App\Repositories\EloquentLearnerRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(LearnerRepositoryInterface::class, EloquentLearnerRepository::class);
    }
}
