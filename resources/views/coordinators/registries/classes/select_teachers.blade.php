<x-layout>
    <h1>Select Teacher for Class: {{ $class->class_name }} - {{ $class->class_year }}</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('coordinators.save_teachers', $class->class_id) }}" method="POST">
        @csrf

        <table>
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Teacher Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teachers as $teacher)
                    <tr>
                        <td>
                            <input type="checkbox" name="teachers[]" value="{{ $teacher->teacher_user_id }}" 
                            {{ $associatedTeachers->contains('teacher_user_id', $teacher->teacher_user_id) ? 'checked' : '' }}>
                        </td>
                        <td>{{ $teacher->teacher_name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit">Update Teacher Association</button>
    </form>

    <a href="{{ route('coordinators.registries.classes.edit', $class->class_id) }}">Back to Edit Class</a>
</x-layout>