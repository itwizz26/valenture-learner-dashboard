<?php

namespace App\Repositories;

use App\Models\Learner;

class EloquentLearnerRepository implements LearnerRepositoryInterface {

    public function getLearnersWithProgress(array $filters = [], string $sortBy = null) 
    {
        $query = Learner::query()
            ->select('learners.*')
            ->with(['courses']);

        if (!empty($filters['course_id'])) {
            $query->whereHas('courses', function ($q) use ($filters) {
                $q->where('courses.id', $filters['course_id']);
            });
        }

        if ($sortBy === 'progress_asc' || $sortBy === 'progress_desc') {
            $direction = $sortBy === 'progress_desc' ? 'DESC' : 'ASC';
            
            $query->leftJoin('enrolments', 'learners.id', '=', 'enrolments.learner_id')
                ->orderBy('enrolments.progress', $direction);
        }

        return $query->get();
    }
}
