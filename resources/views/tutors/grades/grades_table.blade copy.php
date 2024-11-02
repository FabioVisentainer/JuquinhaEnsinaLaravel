<x-layout>
    <a href="{{ route('tutors.home.student.get', [$studentUserId]) }}">Voltar</a><br><br>
    <h1>Boletim - {{ $student->student_name }}</h1>

    <p>Student user ID: {{ $studentUserId }}</p>
    <p>Student Name: {{ $student->student_name }}</p>

    @foreach ($gradeReport as $grade)


    @php
        $currentClass = null;
    @endphp

    @foreach ($gradeReport as $grade)
        @if ($currentClass !== "{$grade->class_name} - {$grade->class_year}")
            @if ($currentClass !== null)
                </tbody>
                </table>
            @endif

            <h2>Class: {{ $grade->class_name }}</h2>
            <h3>Year: {{ $grade->class_year }}</h3>
            <table>
                <thead>
                    <tr>
                        <th>Subject Name</th>
                        <th>Syllabus Name</th>
                        <th>Concept Abbreviation</th>
                        <th>Evaluation Number</th>
                        <th>Submission Date</th>
                    </tr>
                </thead>
                <tbody>
            @php
                $currentClass = "{$grade->class_name} - {$grade->class_year}";
            @endphp
        @endif

        <tr>
            <td>{{ $grade->class_subject_name }}</td>
            <td>{{ $grade->class_syllabus_name }}</td>
            <td>{{ $grade->concept_abbreviation }}</td>
            <td>{{ $grade->evaluation_number }}</td>
            <td>{{ $grade->submission_date ?? 'N/A' }}</td>
        </tr>
    @endforeach

    @if ($currentClass !== null)
        </tbody>
        </table>
    @endif

    @if ($gradeReport->isEmpty())
        <p>No grades available for this student.</p>
    @endif
</x-layout>