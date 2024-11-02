<x-layout>
    <h1>Select Chronogram for Class: {{ $class->class_name }} - {{ $class->class_year }}</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('coordinators.save_chronograms', $class->class_id) }}" method="POST">
        @csrf

        <table>
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Chronogram Name</th>
                    <th>Create Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($chronograms as $chronogram)
                    <tr>
                        <td>
                            <input type="radio" name="chronogram_id" value="{{ $chronogram->chronogram_id }}">
                        </td>
                        <td>{{ $chronogram->chronogram_name }}</td>
                        <td>{{ $chronogram->created_at->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit">Update Chronogram Association</button>
    </form>

    <a href="{{ route('coordinators.registries.classes.edit', $class->class_id) }}">Back to Edit Class</a>
</x-layout>