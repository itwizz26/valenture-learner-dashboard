<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ProgressRequest;
use App\Models\Course;
use App\Services\ProgressService;
use Inertia\Inertia;

class LearnerProgressController
{
    public function index(ProgressRequest $request, ProgressService $service)
    {
        $filters = $request->validated();

        return Inertia::render('LearnerProgress/Index', [
            'learners' => $service->getDashboardData($filters),
            'courses' => Course::query()
                ->select('id', 'name')
                ->orderBy('name')
                ->get()
                ->unique('id')
                ->values(),
            'filters' => $filters,
        ]);
    }
}
