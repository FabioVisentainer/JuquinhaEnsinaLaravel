<x-layout>
<a href="{{ route('coordinators.home') }}">Voltar</a><br><br>
<h1>Cadastro de Disciplinas</h1>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<a href="{{ route('coordinators.registries.classessubjects.new') }}">Nova Disciplina</a><br><br>

@if($classessubjects->isEmpty())
    <p>No Classes found for your entity.</p>
@else
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Created Date</th>
                <th>Active?</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($classessubjects as $classsubject)
                <tr>
                    <td>{{ $classsubject->class_subject_name }}</td>
                    <td>{{ $classsubject->created_at }}</td>
                    <td>{{ $classsubject->is_active }}</td>
                    <td>
                        <a href="{{ route('coordinators.registries.classessubjects.edit',  $classsubject->class_subject_id) }}">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

</x-layout>