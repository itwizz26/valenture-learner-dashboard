<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProgressRequest;
use App\Services\ProgressService;

class LearnerProgressController
{
    public function index(ProgressRequest $request, ProgressService $service)
    {
        $learners = $service->getDashboardData($request->validated());
        $courses = \App\Models\Course::all();

        return view('learner-progress.index', compact('learners', 'courses'));
    }
}
