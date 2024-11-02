<x-layout>
<a href="{{ route('coordinators.registries.chronograms.home') }}">Voltar</a><br><br>
    <h1>Register New Chronogram</h1>

    <form action="{{ route('coordinators.registries.chronograms.store',) }}" method="POST">
        @csrf

        <!-- Include the form component for chronogram and pass the teachers variable -->
        <x-registries.chronogram_form />

        <button type="submit">Register Chronogram</button>
    </form>

    <x-errors />
</x-layout>