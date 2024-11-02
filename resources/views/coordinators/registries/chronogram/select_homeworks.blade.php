<x-layout>
    <h1>Select Homeworks for Chronogram: {{ $chronogram->chronogram_name }}</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('coordinators.save_homeworks', $chronogram->chronogram_id) }}" method="POST">
        @csrf

        <table>
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Homework Name</th>
                    <th>Homework URL</th>
                    <th>Release Date</th>
                    <th>Due Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($homeworks as $homework)
                    @php
                        // Fetch the associated homework from the $associatedHomeworks collection
                        $associatedHomework = $associatedHomeworks->firstWhere('homework_id', $homework->homework_id);
                    @endphp

                    <tr>
                        <td>
                            <input type="checkbox" name="homeworks[]" value="{{ $homework->homework_id }}" 
                                {{ $associatedHomework ? 'checked' : '' }}
                                onchange="toggleDateFields({{ $homework->homework_id }})">
                        </td>
                        <td>{{ $homework->homework_name }}</td>
                        <td>{{ $homework->homework_url }}</td>
                        <td>
                            <input type="datetime-local" id="release_date_{{ $homework->homework_id }}" 
                                name="release_dates[{{ $homework->homework_id }}]" 
                                value="{{ $associatedHomework ? \Carbon\Carbon::parse($associatedHomework->pivot->release_date)->format('Y-m-d\TH:i') : '' }}"
                                {{ $associatedHomework ? '' : 'disabled' }}>
                        </td>
                        <td>
                            <input type="datetime-local" id="due_date_{{ $homework->homework_id }}" 
                                name="due_dates[{{ $homework->homework_id }}]" 
                                value="{{ $associatedHomework ? \Carbon\Carbon::parse($associatedHomework->pivot->due_date)->format('Y-m-d\TH:i') : '' }}"
                                {{ $associatedHomework ? '' : 'disabled' }}>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit">Update Homework Associations</button>
    </form>

    <a href="{{ route('coordinators.registries.chronograms.edit', $chronogram->chronogram_id) }}">Back to Edit Chronogram</a>

    <script>
        function toggleDateFields(homeworkId) {
            const checkbox = document.querySelector(`input[name="homeworks[]"][value="${homeworkId}"]`);
            const releaseDateField = document.getElementById(`release_date_${homeworkId}`);
            const dueDateField = document.getElementById(`due_date_${homeworkId}`);

            // Enable or disable date fields based on checkbox state
            releaseDateField.disabled = !checkbox.checked;
            dueDateField.disabled = !checkbox.checked;
        }
    </script>
</x-layout>