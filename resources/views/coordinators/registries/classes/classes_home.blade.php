<x-layout>
<a href="{{ route('coordinators.home') }}">Voltar</a><br><br>
<h1>Cadastro de Turmas</h1>
<p>Atenção: Para Salvar Alterações de Disciplinas e Assuntos aos alunos é preciso adicionalos a Turma somente depois de ter editado a Disciplina/Turma</p>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<a href="{{ route('coordinators.registries.classes.new') }}">Nova Turma</a><br><br>

@if($classes->isEmpty())
    <p>No Classes found for your entity.</p>
@else
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Class Year</th>
                <th>Created Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($classes as $class)
                <tr>
                    <td>{{ $class->class_name }}</td>
                    <td>{{ $class->class_year }}</td>
                    <td>{{ $class->created_at }}</td>
                    <td>
                        <a href="{{ route('coordinators.registries.classes.edit', $class->class_id ) }}">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

</x-layout>