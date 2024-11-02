<x-layout>
    <a href="{{ route('tutors.home.student.get', [$studentUserId]) }}">Voltar</a><br><br>
    <h1>Boletim - {{ $student->student_name }}</h1>

    <p>Student user ID: {{ $studentUserId }}</p>
    <p>Student Name: {{ $student->student_name }}</p>

    <table>
        <thead>
            <tr>
                <th>Concept Name</th>
                <th>Abbreviation</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($concepts as $concept)
                <tr>
                    <td>{{ $concept->concept_name }}</td>
                    <td>{{ $concept->concept_abbreviation }}</td>
                    <td>{{ $concept->concept_description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @foreach ($gradeReport as $class => $subjects)
        <h2>Class: {{ explode(' - ', $class)[0] }}</h2>
        <h3>Year: {{ explode(' - ', $class)[1] }}</h3>
        <table>
            <thead>
                <tr>
                    <th>Subject Name</th>
                    <th>Syllabus Name</th>
                    @php
                        $maxEvaluations = 0;
                        foreach ($subjects as $subject) {
                            $maxEvaluations = max($maxEvaluations, count($subject['evaluations']));
                        }
                    @endphp
                    @for ($i = 1; $i <= $maxEvaluations; $i++)
                        <th>Evaluation {{ $i }}</th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @foreach ($subjects as $subject => $data)
                    <tr>
                        <td>{{ explode(' - ', $subject)[0] }}</td>
                        <td>{{ explode(' - ', $subject)[1] }}</td>
                        @for ($i = 1; $i <= $maxEvaluations; $i++)
                            <td>{{ $data['evaluations'][$i] ?? 'N/A' }}</td>
                        @endfor
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endforeach

    @if (empty($gradeReport))
        <p>No grades available for this student.</p>
    @endif
</x-layout>