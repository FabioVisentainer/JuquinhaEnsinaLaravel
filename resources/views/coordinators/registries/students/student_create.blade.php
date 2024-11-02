<x-layout>
    <a href="{{ route('coordinators.registries.students.home') }}">Voltar</a><br><br>
    <h1>Register New Student</h1>

    <form action="{{ route('coordinators.registries.students.store') }}" method="POST">
        @csrf

        <!-- Fetch special needs data -->
        @php
            $specialNeeds = DB::table('tb_special_needs')->get();
        @endphp

        <!-- Use the student registration form -->
        <x-registries.student_form :specialNeeds="$specialNeeds" />

        <button type="submit">Register Student</button>
    </form>

    <x-errors />
</x-layout>