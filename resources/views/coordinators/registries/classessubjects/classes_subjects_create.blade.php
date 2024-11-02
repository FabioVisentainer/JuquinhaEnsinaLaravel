<x-layout>
<a href="{{ route('coordinators.registries.classessubjects.home') }}">Voltar</a><br><br>
    <h1>Register New Class Subject</h1>

    <form action="{{ route('coordinators.registries.classessubjects.store') }}" method="POST">
        @csrf

        <!-- Include the form component -->
        <x-registries.class_subjects_form />

        <button type="submit">Register Class Subject</button>
    </form>

    <x-errors />
</x-layout>