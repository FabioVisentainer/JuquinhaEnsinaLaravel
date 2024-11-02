<x-layout>
    <a href="{{ route('tutors.home.student.get', [$studentUserId]) }}">Voltar</a><br><br>
    <h1>Tarefas - {{ $student->student_name }} - {{ $classInfo->class_name }} - {{ $classInfo->class_year }}</h1>

    <p>Student user ID: {{ $studentUserId }}</p>
    <p>Student Name: {{ $student->student_name }}</p>

    <h2>Activities</h2>
    <table>
        <thead>
            <tr>
                <th>Activity ID</th>
                <th>Activity Name</th>
                <th>Status</th>
                <th>Times Complete</th>
                <th>Last Completed Time</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($activities as $activity)
                <tr>
                    <td>{{ $activity->activity_id }}</td>
                    <td>{{ $activity->activity_name }}</td>
                    <td>{{ $activity->status }}</td>
                    <td>{{ $activity->times_completed }}</td>
                    <td>{{ $activity->last_completed_time ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>


</x-layout>