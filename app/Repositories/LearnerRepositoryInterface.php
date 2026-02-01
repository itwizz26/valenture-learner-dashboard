<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Support\Collection;

interface LearnerRepositoryInterface
{
    /**
     * Only expect the filters array.
     */
    public function getLearnersWithProgress(array $filters = []): Collection;
}
