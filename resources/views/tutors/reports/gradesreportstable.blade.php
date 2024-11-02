<x-layout>
    <a href="{{ route('tutors.reports.home', [$studentUserId]) }}">Voltar</a><br><br>

    <h1>Relatório de Notas</h1>
    <button id="load-grades-report">Carregar Relatório</button>
    <div id="grades-report" style="margin-top: 20px;"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#load-grades-report').click(function() {
                $.ajax({
                    url: '{{ route("tutors.fetchGradesData", [$studentUserId]) }}',
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