<x-layout>
    <a href="{{ route('teachers.grades.home') }}">Voltar</a><br><br>
    <h1>Boletim dos Alunos - {{ $class->class_name }} - {{ $class->class_year }} </h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <br>

    @if($students->isEmpty())
        <p>Não há Estudantes Nesta Turma.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Nome do Aluno</th>
                    <th>Ações</th>
                    @foreach($evaluations->unique('evaluation_number') as $evaluation)
                        <th>Boletim {{ $evaluation->evaluation_number }}</th>
                        <th>Última Atualização</th>
                        <th>Ações</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                    <tr>
                        <td>{{ $student->student_name }}</td>
                        <!-- Link to create a new grade for this student -->
                        <td>
                        <a href="{{ route('teachers.grades.create', ['student_user_id' => $student->student_user_id, 'class_id' => $class->class_id]) }}">Novo Boletim</a>
                        </td>
                        <!-- Display evaluations for each student -->
                        @foreach($evaluations->where('student_user_id', $student->student_user_id) as $evaluation)
                            <td>{{ $evaluation->evaluation_number }}</td>
                            <td>{{ $evaluation->updated_at }}</td>
                            <td>
                            <a href="{{ route('teachers.grades.edit', ['student_user_id' => $student->student_user_id, 'evaluation_id' => $evaluation->evaluation_id, 'class_id' => $class->class_id]) }}">Editar</a>
                            </td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</x-layout>