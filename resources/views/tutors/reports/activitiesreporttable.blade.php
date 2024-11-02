<x-layout>
    <a href="{{ route('tutors.reports.home', [$studentUserId]) }}">Voltar</a><br><br>

    <h1>Relatório de Atividades</h1>
    <button id="load-activities-report">Carregar Relatório</button>
    <div id="activities-report" style="margin-top: 20px;"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#load-activities-report').click(function() {
                $.ajax({
                    url: '{{ route("tutors.fetchActivitiesData", [$studentUserId]) }}',
                    type: 'GET',
                    success: function(data) {
                        let reportHtml = '';

                        // Activities Summary for the Current Year
                        reportHtml += '<h2>Resumo de Atividades do Ano</h2>';
                        reportHtml += '<table border="1"><tr><th>Atividade</th><th>Total de Conclusões</th></tr>';
                        data.yearsData.forEach(activity => {
                            reportHtml += `<tr><td>${activity.activity_name}</td><td>${activity.total_times_completed}</td></tr>`;
                        });
                        reportHtml += '</table>';

                        // Activities by Student
                        reportHtml += '<h2>Atividades por Aluno</h2>';
                        reportHtml += '<table border="1"><tr><th>Aluno</th><th>Atividade</th><th>Total de Conclusões</th></tr>';
                        data.activitiesData.forEach(student => {
                            reportHtml += `<tr><td>${student.student_name}</td><td>${student.activity_name}</td><td>${student.total_times_completed}</td></tr>`;
                        });
                        reportHtml += '</table>';

                        $('#activities-report').html(reportHtml);
                    },
                    error: function() {
                        $('#activities-report').html('<p>Erro ao carregar o relatório.</p>');
                    }
                });
            });
        });
    </script>
</x-layout>