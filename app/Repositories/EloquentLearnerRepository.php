<?php

namespace App\Repositories;

use App\Models\Learner;

class EloquentLearnerRepository implements LearnerRepositoryInterface {
    public function getLearnersWithProgress(array $filters = [], string $sortBy = null) {
        $query = Learner::with(['courses']);

        if (!empty($filters['course_id'])) {
            $query->whereHas('courses', function ($q) use ($filters) {
                $q->where('courses.id', $filters['course_id']);
            });
        }

        return $query->get();
    }
}
