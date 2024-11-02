<x-layout>
    <a href="{{ route('teachers.homework.home') }}">Voltar</a><br><br>
    <h1>Liberação de Tarefas - {{ $class->class_name }} - {{ $class->class_year }}</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <br>

    @if($homeworks->isEmpty())
        <p>Não há Registros de Tarefas para esta turma.</p>
    @else
        <form action="{{ route('teachers.homework.update', ['class_id' => $class->class_id]) }}" method="POST">
            @csrf
            @method('PUT')

            <table>
                <thead>
                    <tr>
                        <th>Tarefa</th>
                        <th>Descrição</th>
                        <th>Data de Entrega</th>
                        <th>Data de Liberação</th>
                        <th>Liberar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($homeworks as $homework)
                        <tr>
                            <td>{{ $homework->homework_name }}</td>
                            <td>
                                <input type="text" name="homework[{{ $homework->homework_id }}][description]" 
                                    value="{{ old('homework.' . $homework->homework_id . '.description', $relatedHomeworks[$homework->homework_id]->description ?? '') }}" 
                                    {{ isset($relatedHomeworks[$homework->homework_id]) && $relatedHomeworks[$homework->homework_id]->is_active ? 'required' : '' }}>
                            </td>
                            <td>
                                <input type="datetime-local" name="homework[{{ $homework->homework_id }}][due_date]" 
                                    value="{{ old('homework.' . $homework->homework_id . '.due_date', $relatedHomeworks[$homework->homework_id]->due_date ?? '') }}" 
                                    {{ isset($relatedHomeworks[$homework->homework_id]) && $relatedHomeworks[$homework->homework_id]->is_active ? 'required' : '' }}>
                            </td>
                            <td>
                                <input type="datetime-local" name="homework[{{ $homework->homework_id }}][release_date]" 
                                    value="{{ old('homework.' . $homework->homework_id . '.release_date', $relatedHomeworks[$homework->homework_id]->release_date ?? '') }}" 
                                    {{ isset($relatedHomeworks[$homework->homework_id]) && $relatedHomeworks[$homework->homework_id]->is_active ? 'required' : '' }}>
                            </td>
                            <td>
                                <input type="hidden" name="homework[{{ $homework->homework_id }}][is_active]" value="0">
                                <input type="checkbox" name="homework[{{ $homework->homework_id }}][is_active]" value="1"
                                       {{ isset($relatedHomeworks[$homework->homework_id]) && $relatedHomeworks[$homework->homework_id]->is_active ? 'checked' : '' }}>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="submit">Salvar Alterações</button>
          
        </form>
    @endif

    <h1>Students with Incomplete Homework</h1>

    @if($studentsWithIncompleteHomeworks->isEmpty())
        <p>No students have incomplete homework for this class.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Homework Name</th>
                    <th>Due Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($studentsWithIncompleteHomeworks as $student)
                    <tr>
                        <td>{{ $student->student_name }}</td>
                        <td>{{ $student->homework_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($student->due_date)->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</x-layout>