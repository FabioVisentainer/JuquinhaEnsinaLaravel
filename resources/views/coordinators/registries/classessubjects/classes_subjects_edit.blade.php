<x-layout>
<a href="{{ route('coordinators.registries.classessubjects.home') }}">Voltar</a><br><br>
    <h1>Edit Class Subject</h1>

    <form action="{{ route('coordinators.registries.classessubjects.update', $classSubject->class_subject_id) }}" method="POST">
        @csrf
        @method('PUT')

        <x-registries.class_subjects_form :classSubject="$classSubject" />

        <button type="submit">Update Class Subject</button>
    </form>

    <h2>Syllabus</h2>
    <a href="{{ route('coordinators.registries.classessubjects.syllabus.create', $classSubject->class_subject_id) }}">Add New Syllabus</a>

    @if($syllabus->isNotEmpty())
        <ul>
            @foreach($syllabus as $syllabi)
                <li>
                    {{ $syllabi->class_syllabus_name }} - {{ $syllabi->class_syllabus_description }}
                    @if($syllabi->is_active)
                        <span>(Active)</span>
                    @else
                        <span>(Inactive)</span>
                    @endif
                    <a href="{{ route('coordinators.registries.classessubjects.syllabus.edit', $syllabi->class_syllabus_id) }}">Edit</a>
                </li>
            @endforeach
        </ul>
    @else
        <p>No syllabus added yet.</p>
    @endif

    <x-errors />
</x-layout>