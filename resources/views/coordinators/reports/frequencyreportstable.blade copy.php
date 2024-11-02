<x-layout>
    <a href="{{ route('coordinators.reports.home') }}">Voltar</a><br><br>

    <h1>Relatório de Frequência</h1>
    <button id="load-report">Carregar Relatório</button>
    <div id="report" style="margin-top: 20px;"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        
        $(document).ready(function() {
            $('#load-report').click(function() {
                $.ajax({
                    url: '{{ route("coordinators.fetchFrequencyData") }}',
                    type: 'GET',
                    success: function(data) {
                        let reportHtml = '';

                        // Frequency by Year
                        reportHtml += '<h2>Frequência por Ano</h2>';
                        reportHtml += '<table border="1"><tr><th>Ano</th><th>% Presente</th><th>Total</th></tr>';
                        data.yearly.forEach(year => {
                            reportHtml += `<tr><td>${year.class_year}</td><td>${year.present_percentage}%</td><td>${year.total_count}</td></tr>`;
                        });
                        reportHtml += '</table>';

                        // Frequency by Class
                        reportHtml += '<h2>Frequência por Classe</h2>';
                        data.class.forEach(cls => {
                            // Calculate class percentage
                            const totalAttendance = cls.total_count; // Total attendance for the class
                            const presentCount = cls.present_count; // Present count for the class
                            const classPercentage = totalAttendance ? (presentCount * 100 / totalAttendance).toFixed(2) : 0;

                            reportHtml += `<h3>${cls.class_name} (${cls.class_year}) - ${classPercentage}% Presente</h3>`;
                            reportHtml += '<table border="1"><tr><th>Aluno</th><th>% Presente</th><th>Total</th></tr>';

                            // Find students for this class
                            const students = data.student.filter(student => student.class_name === cls.class_name && student.class_year === cls.class_year);
                            students.forEach(student => {
                                reportHtml += `<tr><td>${student.student_name}</td><td>${student.present_percentage}%</td><td>${student.total_count}</td></tr>`;
                            });

                            reportHtml += '</table>';
                        });

                        $('#report').html(reportHtml);
                    },
                    error: function() {
                        $('#report').html('<p>Erro ao carregar o relatório.</p>');
                    }
                });
            });
        });
    </script>
</x-layout>