<x-layout>
    <a href="{{ route('Mainhome') }}">Voltar</a><br><br>
    <h1>Tutor</h1>

    <p>Student user ID: {{ $studentUserId }}</p>
    <p>Student Name: {{ $students->firstWhere('student_user_id', $studentUserId)->student_name ?? 'N/A' }}</p>

    <form method="POST" id="studentForm">
        @csrf
        <label for="students">Select Student:</label>
        <select id="students" name="student_user_id" onchange="submitForm()">
            @foreach ($students as $student)
                <option value="{{ $student->student_user_id }}"
                    {{ $student->student_user_id == $studentUserId ? 'selected' : '' }}>
                    {{ $student->student_name }}
                </option>
            @endforeach
        </select>
    </form>

    <br><br>
    <a href="{{ route('tutors.homework.table', [$studentUserId]) }}">Ver Tarefas</a><br><br>
    <a href="{{ route('tutors.activity.table', [$studentUserId]) }}">Ver Atividades</a><br><br>
    <a href="{{ route('tutors.reports.home', [$studentUserId]) }}">Ver Desempenho do Aluno</a><br><br>
    <a href="{{ route('tutors.grades.table', [$studentUserId]) }}">Ver Boletim do Aluno</a><br><br>
    <a href="{{ route('tutors.videos.home', [$studentUserId]) }}">Ver Vídeos</a><br><br>
    <a href="{{ route('tutors.notifications.home', [$studentUserId]) }}">Notificações ({{ $unreadCount }})</a><br><br>

    <script>
        function submitForm() {
            const studentId = document.getElementById('students').value;
            const form = document.getElementById('studentForm');
            form.action = `{{ route('tutors.home.student', '') }}/${studentId}`;
            form.submit();
        }
    </script>
</x-layout>