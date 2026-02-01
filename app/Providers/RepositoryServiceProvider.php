<?php

declare(strict_types=1);

namespace App\Providers;

use App\Repositories\EloquentLearnerRepository;
use App\Repositories\LearnerRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(LearnerRepositoryInterface::class, EloquentLearnerRepository::class);
    }
}
