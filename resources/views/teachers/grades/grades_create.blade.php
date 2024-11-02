<x-layout>
    <a href="{{ route('teachers.grades.table', $classId) }}">Back</a><br><br>
    <h1>Create Grade for Evaluation #{{ $newEvaluationNumber }}</h1>
    <h2>Student: {{ $student->name }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('teachers.grades.store', ['student_user_id' => $student_user_id]) }}" method="POST">
        @csrf
        <input type="hidden" name="entity_id" value="{{ Auth::user()->entity_id }}">
        <input type="hidden" name="teacher_user_id" value="{{ Auth::id() }}">
        <input type="hidden" name="student_user_id" value="{{ $student_user_id }}"> <!-- Keep this hidden field -->
        <input type="hidden" name="class_id" value="{{ $classId }}">

        <table>
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Syllabus</th>
                    <th>Concepts</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($classSyllabus as $syllabus)
                    <tr>
                        <td>
                            @if ($loop->first || $classSyllabus[$loop->index - 1]->class_subject_id !== $syllabus->class_subject_id)
                                {{ $syllabus->class_subject_name }}
                            @else
                                <!-- Leave empty for subsequent rows of the same subject -->
                            @endif
                        </td>
                        <td>
                            {{ $syllabus->class_syllabus_name }}
                        </td>
                        <td>
                            @foreach ($concepts as $concept)
                                <label>
                                    <input type="radio" name="concepts[{{ $syllabus->class_syllabus_id }}]" value="{{ $concept->concept_id }}">
                                    {{ $concept->concept_name }}
                                </label>
                                <br>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit">Add Grade</button>
    </form>
</x-layout>