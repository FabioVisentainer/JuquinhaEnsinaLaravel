<x-layout>
    <a href="{{ route('teachers.activity.home') }}">Voltar</a><br><br>
    <h1>Liberação de Atividades - {{ $class->class_name }} - {{ $class->class_year }}</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <br>

    @if($activities->isEmpty())
        <p>Não há Registros de Atividades para esta turma.</p>
    @else
        <form action="{{ route('teachers.activity.update', ['class_id' => $class->class_id]) }}" method="POST">
            @csrf
            @method('PUT')

            <table>
                <thead>
                    <tr>
                        <th>Atividade</th>
                        <th>Liberar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($activities as $activity)
                        <tr>
                            <td>{{ $activity->activity_name }}</td>
                            <td>
                                <input type="hidden" name="completion[{{ $activity->activity_id }}]" value="0">
                                <input type="checkbox" name="completion[{{ $activity->activity_id }}]" value="1"
                                    {{ $relatedActivities[$activity->activity_id] ?? 0 ? 'checked' : '' }}>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="submit">Salvar Alterações</button>
        </form>
    @endif
</x-layout>