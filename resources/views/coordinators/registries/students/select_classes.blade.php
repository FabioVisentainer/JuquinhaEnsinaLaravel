<x-layout>
    <h1>Select Class for Student: {{ $student->student_name }}</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif  <form action="{{ route('coordinators.save_class', $student->student_id) }}" method="POST">
        @csrf

        <table>
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Class Name</th>
                    <th>Class Year</tg>
                </tr>
            </thead>
            <tbody>
                @foreach($classes as $class)
                    <tr>
                        <td>
                            <input type="radio" name="class" value="{{ $class->class_id }}" 
                            {{ $associatedClasses->contains('class_id', $class->class_id) ? 'checked' : '' }}>
                        </td>
                        <td>{{ $class->class_name }}</td>
                        <td>{{ $class->class_year }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit">Update Class Association</button>
    </form>

    <a href="{{ route('coordinators.registries.students.edit', $student->student_id) }}">Back to Edit Student</a>
</x-layout>