<x-layout>
<a href="{{ route('coordinators.registries.tutors.home') }}">Voltar</a><br><br>
    <h1>Register New Tutor</h1>

    <form action="{{ route('coordinators.registries.tutors.store') }}" method="POST">
        @csrf

        <!-- Use the tutor registration form -->
        <x-registries.tutor_form />

        <button type="submit">Register Tutor</button>
    </form>

    <x-errors />
</x-layout>