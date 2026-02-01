<!DOCTYPE html>
<html>
    <head>
        <style>
            body { font-family: sans-serif; color: #333; }
            .header { text-align: center; margin-bottom: 30px; }
            table { width: 100%; border-collapse: collapse; }
            th, td { padding: 12px; border-bottom: 1px solid #eee; text-align: left; }
            .progress-pill { background: #e0e7ff; color: #4338ca; padding: 4px 8px; border-radius: 4px; font-weight: bold; }
        </style>
    </head>
    <body>
        <div class="header">
            <h1>Learner Progress Report</h1>
            <p>Course: {{ $course }} | Generated: {{ $date }}</p>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Learner</th>
                    <th>Course</th>
                    <th>Progress</th>
                </tr>
            </thead>
            <tbody>
                @foreach($learners as $learner)
                    @foreach($learner->courses as $course)
                        <tr>
                            <td>{{ $learner->full_name }}</td>
                            <td>{{ $course->name }}</td>
                            <td>
                                <span class="progress-pill">
                                    {{ $course->pivot->progress }}%
                                </span>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    </body>
</html>
