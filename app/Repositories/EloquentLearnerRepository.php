<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Learner;
use Illuminate\Support\Facades\DB;
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

        if ($courseId) {
            $query->whereHas('courses', function ($q) use ($courseId) {
                $q->where('courses.id', $courseId);
            });
        }

        if ($sortBy === 'desc' || $sortBy === 'asc') {
            $direction = ($sortBy === 'desc') ? 'desc' : 'asc';

            $query->addSelect([
                'sort_progress' => DB::table('enrolments')
                    ->select('progress')
                    ->whereColumn('learner_id', 'learners.id')
                    ->when($courseId, fn ($q) => $q->where('course_id', $courseId))
                    ->limit(1),
            ])->orderBy('sort_progress', $direction);
        }

        return $query->get();
    }
}
