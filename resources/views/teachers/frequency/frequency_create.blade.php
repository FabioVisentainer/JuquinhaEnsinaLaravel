<x-layout>
<a href="{{ route('teachers.frequency.table', ['class_id' => $class_id]) }}">Voltar</a><br><br>
<h1>Registrar Frequência para a Turma - {{ $date }}</h1>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


<form action="{{ route('teachers.frequency.store') }}" method="post">
        @csrf
        <input type="hidden" name="class_id" value="{{ $class_id }}">
        <input type="hidden" name="date" value="{{ $date }}">
        
        <table>
            <thead>
                <tr>
                    <th>Estudante</th>
                    <th>Presente</th>
                </tr>
            </thead>
            <tbody>
            @foreach($associatedStudents as $student)
                    <tr>
                        <td>{{ $student->student_name }}</td>
                        <td>
                            <!-- Hidden field for "absent" status if not checked -->
                            <input type="hidden" name="attendance[{{ $student->student_user_id }}]" value="0">
                            <!-- Checkbox for "present" status -->
                            <input type="checkbox" name="attendance[{{ $student->student_user_id }}]" value="1" checked>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit">Salvar Frequência</button>
    </form>
</x-layout>