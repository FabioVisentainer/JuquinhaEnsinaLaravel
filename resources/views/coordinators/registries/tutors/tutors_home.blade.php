<x-layout>
<a href="{{ route('coordinators.registries.home') }}">Voltar</a><br><br>
<h1>Cadastro de Responsaveis</h1>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<a href="{{ route('coordinators.registries.tutors.new') }}">Novo Responsavel</a><br><br>

@if($tutors->isEmpty())
    <p>No tutors found for your entity.</p>
@else
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Active?</th>
                <th>Registry Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tutors as $tutor)
                <tr>
                    <td>{{ $tutor->tutor_name }}</td>
                    <td>{{ $tutor->is_active ? 'Active' : 'Inactive' }}</td> 
                    <td>{{ $tutor->tutor_registry_date }}</td>
                    <td>
                        <a href="{{ route('coordinators.registries.tutors.edit', $tutor->tutor_id) }}">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

</x-layout>