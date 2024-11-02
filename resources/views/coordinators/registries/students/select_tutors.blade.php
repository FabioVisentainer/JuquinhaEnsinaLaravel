<x-layout>
    <h1>Select Tutors for Student: {{ $student->student_name }}</h1>
    
    <form action="{{ route('coordinators.registries.students.updateTutors', [$student->student_id, $student->student_user_id]) }}" method="POST">
        @csrf

        <table>
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Name</th>
                    <th>Registry Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tutors as $tutor)
                    <tr>
                        <td>
                            <input type="checkbox" name="tutors[]" value="{{ $tutor->tutor_user_id }}" 
                                {{ $associatedTutors->contains('tutor_user_id', $tutor->tutor_user_id) ? 'checked' : '' }}>
                        </td>
                        <td>{{ $tutor->tutor_name }}</td>
                        <td>{{ $tutor->tutor_registry_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit">Update Tutor Associations</button>
    </form>

    <a href="{{ route('coordinators.registries.students.edit', $student->student_id) }}">Back to Edit Tutor</a>
</x-layout>