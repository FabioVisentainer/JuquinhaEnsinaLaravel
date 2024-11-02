<x-layout>
<a href="{{ route('coordinators.registries.home') }}">Voltar</a><br><br>
<h1>Cadastro de Alunos</h1>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<a href="{{ route('coordinators.registries.students.new') }}">Novo Aluno</a><br><br>

@if($students->isEmpty())
    <p>No students found for your entity.</p>
@else
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Active?</th>
                <th>Gender</th>
                <th>Birth Date</th>
                <th>CPF Number</th>
                <th>Registry Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($students as $student)
                <tr>
                    <td>{{ $student->student_name }}</td>
                    <td>{{ $student->is_active ? 'Active' : 'Inactive' }}</td> 
                    <td>{{ $student->student_gender }}</td>
                    <td>{{ $student->student_birth_date }}</td>
                    <td>{{ $student->student_cpf_number }}</td>
                    <td>{{ $student->student_registry_date }}</td>
                    <td>
                        <a href="{{ route('coordinators.registries.students.edit', $student->student_id) }}">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

</x-layout>