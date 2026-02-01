<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\LearnerRepositoryInterface;
use Illuminate\Support\Collection;

class ProgressService
{
    /**
     * Automatically creates the property on class invocation.
     */
    public function __construct(
        protected LearnerRepositoryInterface $learnerRepository
    ) {}

    public function getDashboardData(array $filters): Collection
    {
        return $this->learnerRepository->getLearnersWithProgress($filters);
    }
}
