<x-layout>
    <a href="{{ route('tutors.reports.home', [$studentUserId]) }}">Voltar</a><br><br>

    <h1>Relatório de Atividades</h1>
    <button id="load-activities-report">Carregar Relatório</button>
    <div id="activities-report" style="margin-top: 20px;"></div>
    <canvas id="activitiesChart" style="display:none; margin-top:20px; max-width:600px;"></canvas>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

                        // Prepare data for the pie chart
                        const activityNames = data.yearsData.map(activity => activity.activity_name);
                        const activityCounts = data.yearsData.map(activity => activity.total_times_completed);

                        // Display chart
                        $('#activitiesChart').show();

                        // Create or update chart
                        if (window.myPieChart) window.myPieChart.destroy(); // Destroy old chart if exists

                        const ctx = document.getElementById('activitiesChart').getContext('2d');
                        window.myPieChart = new Chart(ctx, {
                            type: 'pie',
                            data: {
                                labels: activityNames,
                                datasets: [{
                                    label: 'Atividades Mais Jogadas',
                                    data: activityCounts,
                                    backgroundColor: [
                                        '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40'
                                    ],
                                    hoverOffset: 4
                                }]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top'
                                    },
                                    tooltip: {
                                        callbacks: {
                                            label: function(context) {
                                                const label = context.label || '';
                                                const value = context.raw;
                                                return `${label}: ${value} vezes`;
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    },
                    error: function() {
                        $('#activities-report').html('<p>Erro ao carregar o relatório.</p>');
                    }
                });
            });
        });
    </script>
</x-layout>
