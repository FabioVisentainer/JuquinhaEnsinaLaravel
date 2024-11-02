<x-layout>
<a href="{{ route('teachers.home') }}">Voltar</a><br><br>
<h1>Liberação de Tarefas</h1>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if($classes->isEmpty())
    <p>Sem Turmas disponíveis para este Professor.</p>
@else
    <table>
        <thead>
            <tr>
                <th>Class Name</th>
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
                        <a href="{{ route('teachers.homework.table', [$class->class_id]) }}">Selecionar</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

</x-layout>