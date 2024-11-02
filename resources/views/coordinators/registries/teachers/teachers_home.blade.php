<x-layout>
<a href="{{ route('coordinators.registries.home') }}">Voltar</a><br><br>
<h1>Cadastro de Responsaveis</h1>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<a href="{{ route('coordinators.registries.teachers.new') }}">Novo Professor</a><br><br>

@if($teachers->isEmpty())
    <p>No teachers found for your entity.</p>
@else
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Active?</th>
                <th>Registry Date</th>
                <th>Is Coordinator?</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($teachers as $teacher)
                <tr>
                    <td>{{ $teacher->teacher_name }}</td>
                    <td>{{ $teacher->is_active ? 'Active' : 'Inactive' }}</td> 
                    <td>{{ $teacher->teacher_registry_date }}</td>
                    <td>{{ $teacher->coordinator}}</td>
                    <td>
                        <a href="{{ route('coordinators.registries.teachers.edit', $teacher->teacher_id) }}">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

</x-layout>