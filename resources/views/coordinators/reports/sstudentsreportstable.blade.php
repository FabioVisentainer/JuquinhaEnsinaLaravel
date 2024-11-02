<x-layout>
    <a href="{{ route('coordinators.reports.home') }}">Voltar</a><br><br>

    <h1>Relatório de Alunos com Necessidades Especiais</h1>
    <button id="load-special-students-report">Carregar Relatório</button>
    
    <!-- Canvas para o gráfico -->
    <canvas id="specialNeedsChart" style="max-width: 700px; margin-top: 20px; height: 400px;"></canvas>

    <div id="special-students-report" style="margin-top: 20px;"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        $(document).ready(function() {
            $('#load-special-students-report').click(function() {
                $.ajax({
                    url: '{{ route("coordinators.fetchSstudentsData") }}',
                    type: 'GET',
                    success: function(data) {
                        let reportHtml = '';

                        // pizza
                        const labels = data.totalData.map(specialNeed => specialNeed.special_need_name);
                        const values = data.totalData.map(specialNeed => specialNeed.total_count);
                        createPieChart(labels, values);

                        // tabela 1 
                        reportHtml += '<h2>Total de Alunos com Necessidades Especiais</h2>';
                        reportHtml += '<table border="1" style="margin-top: 10px;"><tr><th>Necessidade Especial</th><th>Total</th></tr>';
                        data.totalData.forEach(specialNeed => {
                            reportHtml += `<tr><td>${specialNeed.special_need_name}</td><td>${specialNeed.total_count}</td></tr>`;
                        });
                        reportHtml += '</table>';

                        // tabela 2
                        reportHtml += '<h2>Alunos com Necessidades Especiais por Turma</h2>';
                        reportHtml += '<table border="1" style="margin-top: 10px;"><tr><th>Necessidade Especial</th><th>Turma</th><th>Ano</th><th>Total</th></tr>';
                        data.classData.forEach(classData => {
                            reportHtml += `<tr><td>${classData.special_need_name}</td><td>${classData.class_name}</td><td>${classData.class_year}</td><td>${classData.total_count}</td></tr>`;
                        });
                        reportHtml += '</table>';

                        $('#special-students-report').html(reportHtml);
                    },
                    error: function() {
                        $('#special-students-report').html('<p>Erro ao carregar o relatório.</p>');
                    }
                });
            });
        });

        function createPieChart(labels, data) {
            const ctx = document.getElementById('specialNeedsChart').getContext('2d');
            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Alunos com Necessidades Especiais',
                        data: data,
                        backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 105, 180, 0.2)',
                        'rgba(0, 191, 255, 0.2)',
                        'rgba(34, 139, 34, 0.2)',
                        'rgba(255, 215, 0, 0.2)',
                        'rgba(128, 0, 128, 0.2)',
                        'rgba(220, 20, 60, 0.2)',
                        'rgba(255, 69, 0, 0.2)',
                        'rgba(0, 206, 209, 0.2)',
                        'rgba(139, 69, 19, 0.2)',
                        'rgba(0, 128, 128, 0.2)',
                        'rgba(75, 0, 130, 0.2)',
                        'rgba(255, 140, 0, 0.2)',
                        'rgba(240, 230, 140, 0.2)',
                        'rgba(0, 255, 127, 0.2)',
                        'rgba(199, 21, 133, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 105, 180, 1)',
                        'rgba(0, 191, 255, 1)',
                        'rgba(34, 139, 34, 1)',
                        'rgba(255, 215, 0, 1)',
                        'rgba(128, 0, 128, 1)',
                        'rgba(220, 20, 60, 1)',
                        'rgba(255, 69, 0, 1)',
                        'rgba(0, 206, 209, 1)',
                        'rgba(139, 69, 19, 1)',
                        'rgba(0, 128, 128, 1)',
                        'rgba(75, 0, 130, 1)',
                        'rgba(255, 140, 0, 1)',
                        'rgba(240, 230, 140, 1)',
                        'rgba(0, 255, 127, 1)',
                        'rgba(199, 21, 133, 1)'
                    ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Total de Alunos com Necessidades Especiais'
                        }
                    }
                }
            });
        }
    </script>
</x-layout>
