<?php

namespace App\Services;

use App\Repositories\LearnerRepositoryInterface;

class ProgressService {
    public function __construct(
        protected LearnerRepositoryInterface $learnerRepo
    ) {}

    public function getDashboardData(array $params) {
        return $this->learnerRepo->getLearnersWithProgress(
            filters: ['course_id' => $params['course_id'] ?? null],
            sortBy: $params['sort_by'] ?? null
        );
    }
}
