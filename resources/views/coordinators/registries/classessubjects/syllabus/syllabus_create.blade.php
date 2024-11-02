<x-layout>
<a href="{{ route('coordinators.registries.classessubjects.edit',  $classSubject->class_subject_id) }}">Voltar</a><br><br>
    <h1>Register New Syllabus</h1>

    <form action="{{ route('coordinators.registries.classessubjects.syllabus.store', $classSubject->class_subject_id) }}" method="POST">
        @csrf

        <!-- Include the form component for syllabus -->
        <x-registries.syllabus_form :classSubject="$classSubject" />

        <button type="submit">Register Syllabus</button>
    </form>

    <x-errors />
</x-layout>