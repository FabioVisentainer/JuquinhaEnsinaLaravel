<x-layout>
    <a href="{{ route('coordinators.notifications.home') }}">Voltar</a><br><br>
    <h1>Notificação Para {{ $tutor->tutor_name }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('coordinators.notifications.store.tutor', ['tutor_id' => $tutor->tutor_user_id]) }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="notification_title">Título da Notificação</label>
            <input type="text" name="notification_title" id="notification_title" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="notifications_message">Mensagem da Notificação</label>
            <textarea name="notifications_message" id="notifications_message" class="form-control" required></textarea>
        </div>

        <input type="hidden" name="entity_id" value="{{ Auth::user()->entity_id }}">
        <input type="hidden" name="from_user_id" value="{{ Auth::id() }}">

        <button type="submit" class="btn btn-primary">Enviar Notificação</button>
    </form>

    <x-errors />
</x-layout>