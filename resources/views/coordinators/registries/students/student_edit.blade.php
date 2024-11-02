<x-layout>
<a href="{{ route('coordinators.registries.students.home') }}">Voltar</a><br><br>
    <h1>Edit Student</h1>

    <form action="{{ route('coordinators.registries.students.update', $student->student_id) }}" method="POST">
        @csrf

        <!-- Fetch special needs data -->
        @php
            $specialNeeds = DB::table('tb_special_needs')->get();
        @endphp

        <!-- Use the same student registration form for editing -->
        <x-registries.student_form :specialNeeds="$specialNeeds" :student="$student" />

        <button type="submit">Update Student</button>
    </form>


    <h2>Associate Tutors</h2>
    <a href="{{ route('coordinators.registries.students.selectTutors', $student->student_id) }}">Select Tutors</a>

    <br><br>




    @if($associatedTutors->isEmpty())
            <p>No tutors associated with this student.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Registry Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($associatedTutors as $associatedtutor)
                    <tr>
                        <td>{{ $associatedtutor->tutor->tutor_name }}</td>
                        <td>{{ $associatedtutor->tutor->tutor_registry_date }}</td>
                        <td>
                            <form action="{{ route('coordinators.registries.students.deleteTutor', [$student->student_id, $associatedtutor->tutor_user_id]) }}" method="POST">
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



    <h2>Associate Classes</h2>
    @if($associatedClasses->isEmpty())
        <a href="{{ route('coordinators.select_class', $student->student_id) }}">Select Classes</a>
    @else
        <table>
            <thead>
                <tr>
                    <th>Class Name</th>
                    <th>Class Year</tg>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($associatedClasses as $associatedClass)
                    <tr>
                        <td>{{ $associatedClass->class_name }}</td>
                        <td>{{ $associatedClass->class_year }}</td>
                        <td>
                            <form action="{{ route('coordinators.delete_class', [$student->student_id, $associatedClass->class_id]) }}" method="POST">
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