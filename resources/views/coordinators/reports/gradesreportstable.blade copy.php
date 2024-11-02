<x-layout>
    <a href="{{ route('coordinators.reports.home') }}">Voltar</a><br><br>

    <h1>Relatório de Notas</h1>
    <button id="load-grades-report">Carregar Relatório</button>
    <div id="grades-report" style="margin-top: 20px;"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#load-grades-report').click(function() {
                $.ajax({
                    url: '{{ route("coordinators.fetchGradesData") }}',
                    type: 'GET',
                    success: function(data) {
                        let reportHtml = '';

                        // Grades by Class
                        reportHtml += '<h2>Notas por Turma</h2>';
                        reportHtml += '<table border="1"><tr><th>Turma</th><th>Ano</th><th>Avaliação</th><th>Média</th></tr>';
                        data.class.forEach(cls => {
                            reportHtml += `<tr><td>${cls.class_name}</td><td>${cls.class_year}</td><td>${cls.evaluation_number}</td><td>${cls.media}</td></tr>`;
                        });
                        reportHtml += '</table>';

                        // Grades by Subject
                        reportHtml += '<h2>Notas por Disciplina</h2>';
                        reportHtml += '<table border="1"><tr><th>Turma</th><th>Ano</th><th>Avaliação</th><th>Disciplina</th><th>Média</th></tr>';
                        data.subject.forEach(subject => {
                            reportHtml += `<tr><td>${subject.class_name}</td><td>${subject.class_year}</td><td>${subject.evaluation_number}</td><td>${subject.class_subject_name}</td><td>${subject.media}</td></tr>`;
                        });
                        reportHtml += '</table>';

                        // Grades by Student
                        reportHtml += '<h2>Notas por Aluno</h2>';
                        reportHtml += '<table border="1"><tr><th>Aluno</th><th>Turma</th><th>Ano</th><th>Avaliação</th><th>Disciplina</th><th>Média</th></tr>';
                        data.student.forEach(student => {
                            reportHtml += `<tr><td>${student.student_name}</td><td>${student.class_name}</td><td>${student.class_year}</td><td>${student.evaluation_number}</td><td>${student.class_subject_name}</td><td>${student.media}</td></tr>`;
                        });
                        reportHtml += '</table>';

                        $('#grades-report').html(reportHtml);
                    },
                    error: function() {
                        $('#grades-report').html('<p>Erro ao carregar o relatório.</p>');
                    }
                });
            });
        });
    </script>
</x-layout>