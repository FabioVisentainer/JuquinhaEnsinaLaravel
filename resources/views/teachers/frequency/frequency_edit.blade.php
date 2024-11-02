<x-layout>
    <a href="{{ route('teachers.frequency.table', ['class_id' => $class_id]) }}">Voltar</a><br><br>
    <h1>Editar Frequência - {{ $frequency->frequency_date }} - {{ $class_id }}</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('teachers.frequency.update', ['frequency_table_id' => $frequency->frequency_table_id, 'class_id' => $class_id]) }}" method="POST">
        @csrf
        @method('PUT')

        <table>
            <thead>
                <tr>
                    <th>Estudante</th>
                    <th>Presente</th>
                </tr>
            </thead>
            <tbody>
                @foreach($attendanceRecords as $record)
                    <tr>
                        <td>{{ $record->student_user_id }}</td>
                        <td>
                            <input type="hidden" name="attendance[{{ $record->student_user_id }}]" value="0">
                            <input type="checkbox" name="attendance[{{ $record->student_user_id }}]" value="1" {{ $record->preset ? 'checked' : '' }}>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit">Salvar Alterações</button>
    </form>
</x-layout>