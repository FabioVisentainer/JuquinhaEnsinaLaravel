<x-layout>
    <h1>Select Students for Tutor: {{ $tutor->tutor_name }}</h1>
    
    <form action="{{ route('coordinators.registries.tutors.updateStudents', [$tutor->tutor_id, $tutor->tutor_user_id]) }}" method="POST">
        @csrf

        <table>
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Registry Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                    <tr>
                        <td>
                            <input type="checkbox" name="students[]" value="{{ $student->student_user_id }}" 
                                {{ $associatedStudents->contains('student_user_id', $student->student_user_id) ? 'checked' : '' }}>
                        </td>
                        <td>{{ $student->student_name }}</td>
                        <td>{{ $student->student_gender }}</td>
                        <td>{{ $student->student_registry_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit">Update Student Associations</button>
    </form>

    <a href="{{ route('coordinators.registries.tutors.edit', $tutor->tutor_id) }}">Back to Edit Tutor</a>
</x-layout>