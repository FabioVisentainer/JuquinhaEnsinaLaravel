<x-layout>
    <a href="{{ route('students.home') }}">Voltar</a><br><br>
    <h1>Tarefas - {{ $student->student_name }} - {{ $classInfo->class_name }} - {{ $classInfo->class_year }}</h1>

    <h2>Available Homeworks</h2>
    <table>
        <thead>
            <tr>
                <th>Homework ID</th>
                <th>Name</th>
                <th>Description</th>
                <th>Release Date</th>
                <th>Due Date</th>
                <th>Start Homework</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($AvailableHomeworks as $homework)
                <tr>
                    <td>{{ $homework->homework_id }}</td>
                    <td>{{ $homework->homework_name }}</td>
                    <td>{{ $homework->description }}</td>
                    <td>{{ $homework->release_date ?? 'N/A' }}</td>
                    <td>{{ $homework->due_date ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ asset($homework->homework_url) }}" target="_blank">Start</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Completed Homeworks</h2>
    <table>
        <thead>
            <tr>
                <th>Homework ID</th>
                <th>Submission Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($CompleteHomeworks as $completedHomework)
                <tr>
                    <td>{{ $completedHomework->homework_id }}</td>
                    <td>{{ $completedHomework->updated_at ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>


    <br>


</x-layout>