<x-layout>
    <a href="{{ route('teachers.frequency.home') }}">Voltar</a><br><br>
    <h1>Registros de Frequência - {{ $class->class_name }} - {{ $class->class_year }} </h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Date Selection Form -->
    <form id="frequencyForm" onsubmit="event.preventDefault(); submitFrequencyForm();">
        <label for="date">Data da Frequência:</label>
        <input type="date" id="date" name="date" value="{{ date('Y-m-d') }}" required>
        <button type="submit">Realizar Chamada</button>
    </form>

    <br>

    @if($frequencytable->isEmpty())
        <p>Não há Registros de Frequência para esta turma.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Data de Frequência</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach($frequencytable as $frequency)
                    <tr>
                        <td>{{ $frequency->frequency_date }}</td>
                        <td>
                        <a href="{{ route('teachers.frequency.edit', ['class_id' => $class->class_id, 'frequency_table_id' => $frequency->frequency_table_id]) }}">Editar</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- JavaScript to handle form submission -->
    <script>
        function submitFrequencyForm() {
            const date = document.getElementById('date').value;
            const classId = "{{ $class->class_id }}"; // Dynamically extract class_id from $class
            const url = `{{ route('teachers.frequency.create', ['class_id' => '__class_id__', 'date' => '__date__']) }}`
                .replace('__class_id__', classId)
                .replace('__date__', date);
            window.location.href = url;
        }
    </script>
</x-layout>