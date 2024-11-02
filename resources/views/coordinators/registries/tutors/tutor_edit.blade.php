<x-layout>
<a href="{{ route('coordinators.registries.tutors.home') }}">Voltar</a><br><br>
    <h1>Edit Tutor</h1>

    <form action="{{ route('coordinators.registries.tutors.update', $tutor->tutor_id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Add this line to specify the PUT method -->


        
        <!-- Use the tutor registration form -->
        <x-registries.tutor_form 
            :tutor="$tutor" 
            :cities="$cities"  
        />


        <button type="submit">Update Tutor</button>
    </form>
    
    <h2>Associate Students</h2>
        <a href="{{ route('coordinators.registries.tutors.selectStudents', $tutor->tutor_id) }}">Select Students</a>

        <br><br>

        @if($associatedStudents->isEmpty())
            <p>No students associated with this tutor.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Registry Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($associatedStudents as $associatedStudent)
                        <tr>
                            <td>{{ $associatedStudent->student->student_name }}</td>
                            <td>{{ $associatedStudent->student->student_gender }}</td>
                            <td>{{ $associatedStudent->student->student_registry_date }}</td>
                            <td>
                                <form action="{{ route('coordinators.registries.tutors.deleteStudents', [$tutor->tutor_id, $associatedStudent->student_user_id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif

    <x-errors />
</x-layout>