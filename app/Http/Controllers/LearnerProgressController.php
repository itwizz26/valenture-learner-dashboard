<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\ProgressRequest;
use App\Models\Course;
use App\Services\ProgressService;
use Barryvdh\DomPDF\Facade\Pdf;
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

    public function export(ProgressRequest $request, ProgressService $service)
    {
        $filters = $request->validated();
        $learners = $service->getDashboardData($filters);

        $pdf = Pdf::loadView('pdf.progress-report', [
            'learners' => $learners,
            'course' => \App\Models\Course::find($filters['course_id'] ?? null)?->name ?? 'All Courses',
            'date' => now()->format('d M Y'),
        ]);

        return $pdf->download('learner-progress-report.pdf');
    }
}
