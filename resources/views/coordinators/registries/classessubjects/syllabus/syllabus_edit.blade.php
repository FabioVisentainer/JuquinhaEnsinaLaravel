<x-layout>
<a href="{{ route('coordinators.registries.classessubjects.edit',  $classSubject->class_subject_id) }}">Voltar</a><br><br>
    <h1>Edit Syllabus</h1>

    <form action="{{ route('coordinators.registries.classessubjects.syllabus.update', $syllabus->class_syllabus_id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Include the form component for syllabus -->
        <x-registries.syllabus_form :syllabus="$syllabus" :classSubject="$classSubject" />

        <button type="submit">Update Syllabus</button>
    </form>

    <x-errors />
</x-layout>