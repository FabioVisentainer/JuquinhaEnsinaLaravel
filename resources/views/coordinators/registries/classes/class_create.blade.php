<x-layout>
<a href="{{ route('coordinators.registries.classes.home') }}">Voltar</a><br><br>
    <h1>Register New Class</h1>

    <form action="{{ route('coordinators.registries.classes.store') }}" method="POST">
        @csrf

        <!-- Include the form component for class and pass the necessary variables -->
        <x-registries.class_form />

        <button type="submit">Register Class</button>
    </form>

    <x-errors />
</x-layout>