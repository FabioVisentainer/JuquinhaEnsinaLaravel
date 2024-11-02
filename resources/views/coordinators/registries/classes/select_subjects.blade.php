<x-layout>
    <h1>Select Subject for Class: {{ $class->class_name }} - {{ $class->class_year }}</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('coordinators.save_subjects', $class->class_id) }}" method="POST">
        @csrf

        <table>
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Teacher Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subjects as $subject)
                    <tr>
                        <td>
                            <input type="checkbox" name="subjects[]" value="{{ $subject->class_subject_id }}" 
                            {{ $associatedSubjects->contains('class_subject_id', $subject->class_subject_id) ? 'checked' : '' }}>
                        </td>
                        <td>{{ $subject->class_subject_name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit">Update Subjects Association</button>
    </form>

    <a href="{{ route('coordinators.registries.classes.edit', $class->class_id) }}">Back to Edit Class</a>
</x-layout>