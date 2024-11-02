<x-layout>
<a href="{{ route('coordinators.registries.classes.home') }}">Voltar</a><br><br>
    <h1>Edit Class: {{ $class->class_name }}</h1>

    <form action="{{ route('coordinators.registries.classes.update', $class->class_id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Include the form component for class and pass the class variable -->
        <x-registries.class_form :class="$class" />

        <button type="submit">Update Class</button>
    </form>


    <h2>Cronogramas Associados</h2>
    <br><br>
    @if($chronograms->isEmpty())
        <h2>Associate Chronograms</h2>
        <a href="{{ route('coordinators.select_chronograms', $class->class_id) }}">Select Chronograms</a>
    @else
        <table>
            <thead>
                <tr>
                    <th>Chronogram Name</th>
                    <th>Create Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($chronograms as $chronogram)
                    <tr>
                        <td>{{ $chronogram->chronogram_name }}</td>
                        <td>{{ $chronogram->created_at->format('Y-m-d H:i') }}</td>
                        <td>
                            <form action="{{ route('coordinators.delete_chronograms', [$class->class_id, $chronogram->chronogram_id]) }}" method="POST">
                                @csrf
                                @method('DELETE') <!-- This line is important -->
                                <button type="submit">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <h2>Associate Teachers</h2>
    <a href="{{ route('coordinators.select_teachers', $class->class_id) }}">Select Teachers</a>
    <br><br>
    @if($chronograms->isEmpty())
        <p>No tutors associated with this student.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Teacher Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teachers as $teacher)
                    <tr>
                        <td>{{ $teacher->teacher_name }}</td>
                        <td>
                            <form action="{{ route('coordinators.delete_teachers', [$class->class_id, $teacher->teacher_user_id]) }}" method="POST">
                                @csrf
                                @method('DELETE') <!-- This line is important -->
                                <button type="submit">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <h2>Associar Disciplinas</h2>
    <a href="{{ route('coordinators.select_subjects', $class->class_id) }}">Select Subjects</a>
    <br><br>
    @if($classsubjects->isEmpty())
        <p>No subjects associated with this class.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Subject Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($classsubjects as $classsubject)
                    <tr>
                        <td>{{ $classsubject->class_subject_name }}</td>
                        <td>
                            <form action="{{ route('coordinators.delete_subjects', [$class->class_id, $classsubject->class_subject_id]) }}" method="POST">
                                @csrf
                                @method('DELETE') <!-- This line is important -->
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