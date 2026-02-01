<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProgressRequest;
use App\Services\ProgressService;
use App\Models\Course;
use Inertia\Inertia;

class LearnerProgressController
{
    public function index(ProgressRequest $request, ProgressService $service)
    {
        $learners = $service->getDashboardData($request->validated());
        $courses = \App\Models\Course::all();

        return Inertia::render('LearnerProgress/Index', [
            'learners' => $service->getDashboardData($request->validated()),
            'courses'  => Course::all(),
            'filters'  => $request->only(['course_id', 'sort_by']),
        ]);
    }
}
