<x-layout>
    <a href="{{ route('tutors.home.student.get', [$studentUserId]) }}">Voltar</a><br><br>
    <h1>Tarefas - {{ $student->student_name }} - {{ $classInfo->class_name }} - {{ $classInfo->class_year }}</h1>

    <p>Student user ID: {{ $studentUserId }}</p>
    <p>Student Name: {{ $student->student_name }}</p>

    <h2>Available Homeworks</h2>
    <table>
        <thead>
            <tr>
                <th>Homework ID</th>
                <th>Description</th>
                <th>Release Date</th>
                <th>Due Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($AvailableHomeworks as $homework)
                <tr>
                    <td>{{ $homework->homework_id }}</td>
                    <td>{{ $homework->description }}</td>
                    <td>{{ $homework->release_date ?? 'N/A' }}</td>
                    <td>{{ $homework->due_date ?? 'N/A' }}</td>
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


    <h2>Homeworks</h2>
    <table>
        <thead>
            <tr>
                <th>Homework ID</th>
                <th>Description</th>
                <th>Release Date</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Submission Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($homeworks as $homework)
                <tr>
                    <td>{{ $homework->homework_id }}</td>
                    <td>{{ $homework->description }}</td>
                    <td>{{ $homework->release_date }}</td>
                    <td>{{ $homework->due_date }}</td>
                    <td>{{ $homework->status }}</td>
                    <td>{{ $homework->submission_date ?? 'N/A' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>


</x-layout>