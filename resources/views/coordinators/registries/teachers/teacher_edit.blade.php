<x-layout>
<a href="{{ route('coordinators.registries.teachers.home') }}">Voltar</a><br><br>
    <h1>Edit Teacher</h1>

    <form action="{{ route('coordinators.registries.teachers.update', $teacher->teacher_id) }}" method="POST">
        @csrf
        @method('PUT') <!-- Add this line to specify the PUT method -->


        
        <!-- Use the teacher registration form -->
        <x-registries.teacher_form 
            :teacher="$teacher" 
            :cities="$cities"  
        />

        <button type="submit">Update Teacher</button>
    </form>

    <x-errors />
</x-layout>