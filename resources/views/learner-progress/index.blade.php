<main class="p-8 bg-gray-50 min-h-screen">
    <div class="max-w-6xl mx-auto">
        <header class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Learner Progress Dashboard</h1>
        </header>

        <form action="{{ url('/learner-progress') }}" method="GET" class="flex flex-wrap gap-4 mb-6 bg-white p-4 rounded-lg shadow-sm">
            <div class="flex flex-col">
                <label class="text-xs font-semibold uppercase text-gray-500 mb-1">Filter by Course</label>
                <select name="course_id" onchange="this.form.submit()" class="border-gray-300 rounded-md">
                    <option value="">All Courses</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col">
                <label class="text-xs font-semibold uppercase text-gray-500 mb-1">Sort Progress</label>
                <select name="sort_by" onchange="this.form.submit()" class="border-gray-300 rounded-md">
                    <option value="">None</option>
                    <option value="progress_desc" {{ request('sort_by') == 'progress_desc' ? 'selected' : '' }}>Highest First</option>
                    <option value="progress_asc" {{ request('sort_by') == 'progress_asc' ? 'selected' : '' }}>Lowest First</option>
                </select>
            </div>
        </form>

        <div class="grid gap-6">
            @forelse($learners as $learner)
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h2 class="text-xl font-bold text-blue-600 mb-4">{{ $learner->name }}</h2>
                    <div class="space-y-3">
                        {{-- Simplified: Eloquent relationships return collections, so just loop --}}
                        @foreach($learner->courses as $course)
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="font-medium text-gray-700">{{ $course->name }}</span>
                                    <span class="text-gray-500">{{ $course->pivot->progress }}%</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div class="bg-blue-500 h-2 rounded-full" style="width: {{ $course->pivot->progress }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500 py-12">No learners found matching the criteria.</p>
            @endforelse
        </div>
    </div>
</main>
