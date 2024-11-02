<x-layout>
<a href="{{ route('tutors.home.student.get', [$studentUserId]) }}">Voltar</a><br><br>
    <h1>Minhas Notificações</h1>

    @if($notifications->isEmpty())
        <p>Você não tem notificações.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Professor</th>
                    <th>Título</th>
                    <th>Mensagem</th>
                    <th>Criado em</th>
                </tr>
            </thead>
            <tbody>
                @foreach($notifications as $notification)
                    <tr>
                        <td>{{ $notification->teacher_name ?? 'NI' }}</td>
                        <td>{{ $notification->notification_title }}</td>
                        <td>{{ $notification->notifications_message }}</td>
                        <td>{{ \Carbon\Carbon::parse($notification->created_at)->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $notifications->links() }} <!-- Pagination links -->
    @endif
</x-layout>