<x-layout>
<a href="{{ route('coordinators.home') }}">Voltar</a><br><br>
<h1>Cadastro de Cronogramas</h1>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

    <h2>Turmas</h2>
    @if($classes->isEmpty())
        <p>Não há turmas cadastradas.</p>
    @else
        <ul>
            @foreach($classes as $class)
                <li>
                    {{ $class->class_name }} - Ano: {{ $class->class_year }} - 
                    <a href="{{ route('coordinators.notifications.create.class', ['class_id' => $class->class_id]) }}">Notificar</a>
                </li>
            @endforeach
        </ul>
    @endif

    <h2>Tutores</h2>
    @if($tutors->isEmpty())
        <p>Não há tutores cadastrados.</p>
    @else
        <ul>
            @foreach($tutors as $tutor)
                <li>
                    {{ $tutor->tutor_name }} - 
                    <a href="{{ route('coordinators.notifications.create.tutor', ['tutor_id' => $tutor->tutor_user_id]) }}">Notificar</a>
                </li>
            @endforeach
        </ul>
    @endif

    <h2>Notificações</h2>
    @if($notifications->isEmpty())
        <p>Não há notificações.</p>
    @else
        <ul>
            @foreach($notifications as $notification)
                <li>
                    <strong>{{ $notification->notification_title }}</strong>: {{ $notification->notifications_message }}
                    <em>{{ \Carbon\Carbon::parse($notification->created_at)->format('Y-m-d H:i') }}</em>
                </li>
            @endforeach
        </ul>
    @endif
</x-layout>