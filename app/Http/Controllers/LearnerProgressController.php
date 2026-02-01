<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ProgressRequest;
use App\Services\ProgressService;
use Inertia\Inertia;

class LearnerProgressController
{
    public function index(ProgressRequest $request, ProgressService $service): \Inertia\Response
    {
        $filters = $request->validated();

        return Inertia::render('LearnerProgress/Index', [
            'learners' => $service->getDashboardData($filters),
            'courses' => \App\Models\Course::select('id', 'name')->orderBy('name')->get(),
            'filters' => $filters,
        ]);
    }
}
