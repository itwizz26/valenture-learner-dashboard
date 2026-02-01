<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Learner;
use Illuminate\Support\Collection;

class EloquentLearnerRepository implements LearnerRepositoryInterface
{
    public function getLearnersWithProgress(array $filters = []): Collection
    {
        $courseId = $filters['course_id'] ?? null;
        $sortBy = $filters['sort_by'] ?? null;

        $query = Learner::query()
            ->select('learners.*')
            ->with(['courses' => function ($q) use ($courseId) {
                if ($courseId) {
                    $q->where('courses.id', $courseId);
                }
            }]);

        if ($courseId || $sortBy) {
            $query->join('enrolments', 'learners.id', '=', 'enrolments.learner_id');

            if ($courseId) {
                $query->where('enrolments.course_id', $courseId);
            }

            if ($sortBy) {
                $direction = ($sortBy === 'progress_desc') ? 'DESC' : 'ASC';
                $query->orderBy('enrolments.progress', $direction);
            }

            $query->distinct();
        }

        return $query->get();
    }
}
