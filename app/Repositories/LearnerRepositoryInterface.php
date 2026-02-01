<?php

namespace App\Repositories;

interface LearnerRepositoryInterface {
    public function getLearnersWithProgress(array $filters = [], string $sortBy = null);
}
