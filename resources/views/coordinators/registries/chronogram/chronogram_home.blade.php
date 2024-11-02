<x-layout>
<a href="{{ route('coordinators.home') }}">Voltar</a><br><br>
<h1>Cadastro de Cronogramas</h1>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<a href="{{ route('coordinators.registries.chronograms.new') }}">Novo Cronograma</a><br><br>

@if($chronograms->isEmpty())
    <p>No Chronograms found for your entity.</p>
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
            @foreach($chronograms as $chronogram)
                <tr>
                    <td>{{ $chronogram->chronogram_name }}</td>
                    <td>{{ $chronogram->created_at }}</td>
                    <td>{{ $chronogram->is_active ? 'Yes' : 'No' }}</td> <!-- Show Yes/No for is_active -->
                    <td>
                        <a href="{{ route('coordinators.registries.chronograms.edit', $chronogram->chronogram_id )}}">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

</x-layout>