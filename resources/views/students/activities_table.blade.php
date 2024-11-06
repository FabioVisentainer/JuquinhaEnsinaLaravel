<x-layout>
    <a href="{{ route('students.home') }}">Voltar</a><br><br>
    <h1>Tarefas - {{ $student->student_name }} - {{ $classInfo->class_name }} - {{ $classInfo->class_year }}</h1>

    <p>Student user ID: {{ $studentUserId }}</p>
    <p>Student Name: {{ $student->student_name }}</p>

    <h2>Activities</h2>
    <table>
        <thead>
            <tr>
                <th>Activity Name</th>
                <th>Start Activity</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($AvailableActivities as $activity)
                <tr>
                    <td>{{ $activity->activity_name }}</td>
                    <td>
                        <a href="{{ asset($activity->activity_url) }}" target="_blank">Start</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>


</x-layout>