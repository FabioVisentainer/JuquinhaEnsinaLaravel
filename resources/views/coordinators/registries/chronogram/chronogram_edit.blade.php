<x-layout>
<a href="{{ route('coordinators.registries.chronograms.home') }}">Voltar</a><br><br>
    <h1>Edit Chronogram: {{ $chronogram->chronogram_name }}</h1>

    <form action="{{ route('coordinators.registries.chronograms.update', $chronogram->chronogram_id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Chronogram form component -->
        <x-registries.chronogram_form :chronogram="$chronogram" />

        <button type="submit">Update Chronogram</button>
    </form>

    <h2>Associate Homeworks</h2>
    <a href="{{ route('coordinators.select_homeworks', $chronogram->chronogram_id) }}">Select Homeworks</a>

    <br><br>

    @if($associatedHomeworks->isEmpty())
        <p>No homeworks associated with this chronogram.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Homework Name</th>
                    <th>Release Date</th>
                    <th>Due Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($associatedHomeworks as $associatedHomework)
                    <tr>
                        <td>{{ $associatedHomework->homework_name }}</td>
                        <td>{{ $associatedHomework->pivot->release_date }}</td>
                        <td>{{ $associatedHomework->pivot->due_date }}</td>
                        <td>
                            <form action="{{ route('coordinators.delete_homework', [$chronogram->chronogram_id, $associatedHomework->homework_id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <x-errors />
</x-layout>