<x-layout>
    <a href="{{ route('coordinators.reports.home') }}">Voltar</a><br><br>

    <h1>Relatório de Alunos com Necessidades Especiais</h1>
    <button id="load-special-students-report">Carregar Relatório</button>
    <div id="special-students-report" style="margin-top: 20px;"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#load-special-students-report').click(function() {
                $.ajax({
                    url: '{{ route("coordinators.fetchSstudentsData") }}',
                    type: 'GET',
                    success: function(data) {
                        let reportHtml = '';

                        // Total Special Needs Students
                        reportHtml += '<h2>Total de Alunos com Necessidades Especiais</h2>';
                        reportHtml += '<table border="1"><tr><th>Necessidade Especial</th><th>Total</th></tr>';
                        data.totalData.forEach(specialNeed => {
                            reportHtml += `<tr><td>${specialNeed.special_need_name}</td><td>${specialNeed.total_count}</td></tr>`;
                        });
                        reportHtml += '</table>';

                        // Special Students By Class
                        reportHtml += '<h2>Alunos com Necessidades Especiais por Turma</h2>';
                        reportHtml += '<table border="1"><tr><th>Necessidade Especial</th><th>Turma</th><th>Ano</th><th>Total</th></tr>';
                        data.classData.forEach(classData => {
                            reportHtml += `<tr><td>${classData.special_need_name}</td><td>${classData.class_name}</td><td>${classData.class_year}</td><td>${classData.total_count}</td></tr>`;
                        });
                        reportHtml += '</table>';

                        $('#special-students-report').html(reportHtml);
                    },
                    error: function() {
                        $('#special-students-report').html('<p>Erro ao carregar o relatório.</p>');
                    }
                    }
                });
            });
        });
    </script>
</x-layout>