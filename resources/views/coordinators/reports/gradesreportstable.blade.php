<x-layout>
    <a href="{{ route('coordinators.reports.home') }}">Voltar</a><br><br>

    <h1>Relatório de Notas</h1>
    <button id="load-grades-report">Carregar Relatório</button>
    <div id="grades-report" style="margin-top: 20px;"></div>
    

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function() {
            let chart;
            $('#load-grades-report').click(function() {
                $.ajax({
                    url: '{{ route("coordinators.fetchGradesData") }}',
                    type: 'GET',
                    success: function(data) {
                        let reportHtml = '';

                        reportHtml += '<h1>Relatório de Notas</h1>';
                        reportHtml += '<label for="yearFilter">Filtrar por Ano:</label>';
                        reportHtml += '<select id="yearFilter" style="margin-bottom: 20px;"><option value="">Selecione um ano</option></select>';
                        reportHtml += '<canvas id="gradesBarChart" width="400" height="400" style="margin-top: 20px;"></canvas>';
                        
                        // Grades by Class
                        reportHtml += '<h2>Notas por Turma</h2>';
                        reportHtml += '<table border="1"><tr><th>Turma</th><th>Ano</th><th>Atividade</th><th>Média</th></tr>';
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

                        // NGrades by Student
                        reportHtml += '<h2>Notas por Aluno</h2>';
                        reportHtml += '<table border="1"><tr><th>Aluno</th><th>Turma</th><th>Ano</th><th>Avaliação</th><th>Disciplina</th><th>Média</th></tr>';
                        data.student.forEach(student => {
                            reportHtml += `<tr><td>${student.student_name}</td><td>${student.class_name}</td><td>${student.class_year}</td><td>${student.evaluation_number}</td><td>${student.class_subject_name}</td><td>${student.media}</td></tr>`;
                        });
                        reportHtml += '</table>';

                        $('#grades-report').html(reportHtml);
                        //PROIBIDO DE TIRAR ESSE CODIGO SE NAO NADA FUNCIONA !!!!!!!!!!!!!!!!!!!!!!!!!
                        const uniqueYears = [...new Set(data.class.map(cls => cls.class_year))];
                        const yearFilter = $('#yearFilter');
                        uniqueYears.forEach(year => {
                            yearFilter.append(`<option value="${year}">${year}</option>`);
                        });

                        // Filtro
                        const uniqueActivities = [...new Set(data.class.map(cls => cls.evaluation_number))];
                        const activityFilter = $('#activityFilter');
                        uniqueActivities.forEach(activity => {
                            activityFilter.append(`<option value="${activity}">Atividade ${activity}</option>`);
                        });

                        // Atualizar gráfico com base no ano e na atividade selecionados
                        function updateChart(selectedYear, selectedActivity) {
                            const filteredData = data.class.filter(cls => 
                                (cls.class_year == selectedYear || !selectedYear) && 
                                (cls.evaluation_number == selectedActivity || !selectedActivity)
                            );

                            const labels = [...new Set(filteredData.map(cls => `${cls.class_name}`))];
                            const datasets = uniqueActivities.map(activity => {
                                return {
                                    label: `Atividade ${activity}`,
                                    data: labels.map(className => {
                                        const match = filteredData.find(cls => cls.class_name === className && cls.evaluation_number == activity);
                                        return match ? match.media : null;
                                    }),
                                    backgroundColor: activity % 2 === 0 ? '#36A2EB' : '#FF6384'
                                };
                            });

                            if (chart) {
                                chart.destroy();
                            }

                            const ctx = document.getElementById('gradesBarChart').getContext('2d');
                            chart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: labels,
                                    datasets: datasets
                                },
                                options: {
                                    responsive: true,
                                    scales: {
                                        x: {
                                            title: {
                                                display: true,
                                                text: 'Turma'
                                            }
                                        },
                                        y: {
                                            title: {
                                                display: true,
                                                text: 'Média das Notas'
                                            },
                                            beginAtZero: true
                                        }
                                    },
                                    plugins: {
                                        legend: {
                                            display: true,
                                            position: 'top'
                                        },
                                        tooltip: {
                                            callbacks: {
                                                label: function(context) {
                                                    return `Média: ${context.raw}`;
                                                }
                                            }
                                        }
                                    }
                                }
                            });
                        }

                        $('#yearFilter, #activityFilter').change(function() {
                            const selectedYear = $('#yearFilter').val();
                            const selectedActivity = $('#activityFilter').val();
                            updateChart(selectedYear, selectedActivity);
                        });

                        updateChart('', '');
                    },
                    error: function() {
                        $('#grades-report').html('<p>Erro ao carregar o relatório.</p>');
                    }
                });
            });
        });
    </script>
</x-layout>
