<x-layout>
    <a href="{{ route('coordinators.reports.home') }}">Voltar</a><br><br>

    <h1>Relatório de Frequência</h1>
    <button id="load-report">Carregar Relatório</button>
    <div id="report" style="margin-top: 20px;"></div>

    <!-- Script Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#load-report').click(function() {
                $.ajax({
                    url: '{{ route("coordinators.fetchFrequencyData") }}',
                    type: 'GET',
                    success: function(data) {
                        let reportHtml = '';

                        // Adiciona um canvas para o gráfico de Frequência por Ano
                        reportHtml += '<h2>Frequência por Ano</h2>';
                        reportHtml += '<canvas id="yearlyChart" style="margin-bottom: 20px;"></canvas>';
                        reportHtml += '<table border="1"><tr><th>Ano</th><th>% Presente</th><th>Total</th></tr>';
                        data.yearly.forEach(year => {
                            reportHtml += `<tr><td>${year.class_year}</td><td>${year.present_percentage}%</td><td>${year.total_count}</td></tr>`;
                        });
                        reportHtml += '</table>';
                        // Adiciona canvas para gráficos de Frequência por Classe
                        reportHtml += '<h2>Frequência por Classe</h2>';
                        data.class.forEach((cls, index) => {
                            const classId = `classChart${index + 1}`;
                            reportHtml += `<h3>${cls.class_name} (${cls.class_year})</h3>`;
                            reportHtml += `<canvas id="${classId}" style="margin-bottom: 20px;"></canvas>`;
                        });
                        
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

                        // Gráfico de Frequência por Ano
                        const yearlyLabels = data.yearly.map(year => year.class_year);
                        const yearlyData = data.yearly.map(year => year.present_percentage);
                        const yearlyCtx = document.getElementById('yearlyChart').getContext('2d');
                        new Chart(yearlyCtx, {
                            type: 'bar',
                            data: {
                                labels: yearlyLabels,
                                datasets: [{
                                    label: '% Presente',
                                    data: yearlyData,
                                    backgroundColor: 'rgba(75, 192, 192, 0.6)',
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        max: 100,
                                        title: {
                                            display: true,
                                            text: '% Presente'
                                        }
                                    }
                                }
                            }
                        });

                        // Gráficos de Frequência por Classe
                        data.class.forEach((cls, index) => {
                            const classId = `classChart${index + 1}`;
                            const classLabels = data.student
                                .filter(student => student.class_name === cls.class_name && student.class_year === cls.class_year)
                                .map(student => student.student_name);
                            const classData = data.student
                                .filter(student => student.class_name === cls.class_name && student.class_year === cls.class_year)
                                .map(student => student.present_percentage);

                            const classCtx = document.getElementById(classId).getContext('2d');
                            new Chart(classCtx, {
                                type: 'bar',
                                data: {
                                    labels: classLabels,
                                    datasets: [{
                                        label: '% Presente',
                                        data: classData,
                                        backgroundColor: 'rgba(153, 102, 255, 0.6)',
                                        borderColor: 'rgba(153, 102, 255, 1)',
                                        borderWidth: 1
                                    }]
                                },
                                options: {
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            max: 100,
                                            title: {
                                                display: true,
                                                text: '% Presente'
                                            }
                                        }
                                    }
                                }
                            });
                        });
                    },
                    
                    error: function() {
                        $('#report').html('<p>Erro ao carregar o relatório.</p>');
                    }
                });
            });
        });
    </script>
</x-layout>
