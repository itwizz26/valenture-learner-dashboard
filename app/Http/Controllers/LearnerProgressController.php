<?php

namespace App\Http\Controllers;

use App\Services\ProgressService;

class LearnerProgressController {

    public function index(Request $request, ProgressService $service) {
        $courses = Course::all();
        $learners = $service->getDashboardData($request->all());

        return view('learner-progress.index', compact('learners', 'courses'));
    }
}
