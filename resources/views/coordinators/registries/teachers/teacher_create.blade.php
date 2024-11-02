<x-layout>
<a href="{{ route('coordinators.registries.teachers.home') }}">Voltar</a><br><br>
    <h1>Register New Teacher</h1>

    <form action="{{ route('coordinators.registries.teachers.store') }}" method="POST">
        @csrf

        <!-- Use the tutor registration form -->
        <x-registries.teacher_form />

        <button type="submit">Register Teacher</button>
    </form>

    <x-errors />
</x-layout>