<x-layout>
    <body class="body bg-slate-50">
        <nav class="flex justify-between items-center">
        <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
          <div class="max-[770px]:hidden">
            <!-- Div do botao de voltar -->
            <a href="{{ route('coordinators.reports.home') }}"><img class="invertColor cursor-pointer pointer-events-auto" src="{{ asset('images/voltar.png') }}" alt="Botao de voltar a pagina" width="40px"></a>
          </div>
        </div>
        
        <!-- Div esquerda da nav -->
      
        <div class="">
          <ul class="navText opacity-0 top-[120px] gap-4 sm:pointer-events-auto pointer-events-none">
          <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
            <a href="{{ route('coordinators.home') }}"><p class="navTitle">Inicio</p></a>
          </li>
          <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
            <a href="{{ route('coordinators.registries.home') }}"><p class="navTitle">Cadastros</p></a>
          </li>
          <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
            <a href="{{ route('coordinators.registries.classes.home') }}"><p class="navTitle">Turmas</p></a>
          </li>
          <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
            <a href="{{ route('coordinators.registries.classessubjects.home') }}"><p class="navTitle">Disciplinas</p></a>
          </li>
          <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
            <a href="{{ route('coordinators.registries.chronograms.home') }}"><p class="navTitle">Cronogramas</p></a>
          </li>
          <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
            <a href="{{ route('coordinators.reports.home') }}"><p class="navTitle">Relatórios</p></a>
          </li>
        </ul>
        </div>
        
       
          <div>
            <img class="hamburger invertColor cursor-pointer transition-all ease-out duration-500 md:hidden block max-[800px]:ml-3" src="{{ asset('images/hamburger.png') }}" alt="Hamburger" width="45px">
            <img class="x invertColor cursor-pointer hidden transition-all ease-linear duration-500 md:hidden max-[800px]:ml-3" src="{{ asset('images/x.png') }}" alt="Exit hamburguer" width="30px">
          </div>
      
        <div class="flex gap-8 p-5">
          <!-- Div direita da nav -->
          <div>
            <img class="moon cursor-pointer drop-shadow-[0_0px_16px_rgba(4,15,140)]" src="{{ asset('images/lua.png') }}" alt="" width="40px">
            <img class="sun cursor-pointer dark:drop-shadow-[0_0px_30px_rgba(255,232,150)] hidden" src="{{ asset('images/sol.png') }}" alt="" width="40px">
          </div>
          
          <div>
              <a href="{{ route('coordinators.notifications.home') }}">
                <img id="notificationIcon" class="invertColor cursor-pointer" src="{{ asset('images/notificacao.png') }}" alt="Botao de notificacoes" width="40px">
              </a>
          </div>
      
          <div>
            <img src="{{ asset('images/skillos.png') }}" alt="Company image" width="40px">
          </div>
      
        </div>
        </nav>


        


    {{-- <a href="{{ route('coordinators.reports.home') }}">Voltar</a><br><br> --}}






    <div class="p-6 space-y-8 bg-gray-50 dark:bg-gray-800 min-h-screen">
        <!-- Título do Relatório -->
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Relatório de Frequência</h1>
        </div>
    
        <!-- Botão de Carregar Relatório -->
        <button id="load-report" class="bg-blue-500 text-white py-2 px-6 rounded-md shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Carregar Relatório
        </button>
    
        <!-- Canvas para o Gráfico de Frequência por Ano -->
        <div class="overflow-x-auto sm:overflow-hidden">
            <canvas id="yearlyChart" class="mx-auto mt-6 border-2 border-gray-300 rounded-lg w-full sm:w-[700px] h-[400px]"></canvas>
        </div>
    
        <!-- Relatório de Frequência -->
        <div id="report" class="mt-8 space-y-6">
            <!-- Tabela de Frequência por Ano -->
            <div class="overflow-x-auto sm:overflow-hidden">
                <table class="min-w-full bg-white dark:bg-gray-700 border border-gray-300 rounded-md shadow-md mt-4">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Ano</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">% Presente</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Conteúdo dinâmico será inserido aqui -->
                    </tbody>
                </table>
            </div>
    

        </div>
    </div>
    
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

                        // Tabela de Frequência por Ano
                        reportHtml += '<h2 class="text-2xl font-semibold text-gray-800 dark:text-white mt-4">Frequência por Ano</h2>';
                        reportHtml += '<div class="overflow-x-auto sm:overflow-hidden">';
                        reportHtml += '<table class="min-w-full bg-white dark:bg-gray-700 border border-gray-300 rounded-md shadow-md mt-4"><thead><tr><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Ano</th><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">% Presente</th><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Total</th></tr></thead><tbody>';
                        data.yearly.forEach(year => {
                            reportHtml += `<tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-600">
                                                <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${year.class_year}</td>
                                                <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${year.present_percentage}%</td>
                                                <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${year.total_count}</td>
                                             </tr>`;
                        });
                        reportHtml += '</tbody></table>';
                        reportHtml += '</div>';
    
                        // Frequência por Classe
                        reportHtml += '<h2 class="text-2xl font-semibold text-gray-800 dark:text-white mt-6">Frequência por Classe</h2>';
    
                        data.class.forEach((cls, index) => {
                            const classId = `classChart${index + 1}`;
                            reportHtml += `<h3 class="text-xl font-medium mt-4 text-gray-800 dark:text-white">${cls.class_name} (${cls.class_year})</h3>`;
                            reportHtml += `<canvas id="${classId}" class="mt-4 mb-6"></canvas>`;
    
                            // Calcular o percentual de presença
                            const totalAttendance = cls.total_count;
                            const presentCount = cls.present_count;
                            const classPercentage = totalAttendance ? (presentCount * 100 / totalAttendance).toFixed(2) : 0;
    
                            reportHtml += `<h3 class="text-xl font-medium mt-6 text-gray-800 dark:text-white">${cls.class_name} (${cls.class_year}) - ${classPercentage}% Presente</h3>`;
                            reportHtml += '<table class="min-w-full bg-white dark:bg-gray-700 border border-gray-300 rounded-md shadow-md mt-4"><thead><tr><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Aluno</th><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">% Presente</th><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Total</th></tr></thead><tbody>';
    
                            // Filtrando alunos pela turma
                            const students = data.student.filter(student => student.class_name === cls.class_name && student.class_year === cls.class_year);

                            students.forEach(student => {
                                reportHtml += `<tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-600">
                                                    <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${student.student_name}</td>
                                                    <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${student.present_percentage}%</td>
                                                    <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${student.total_count}</td>
                                                 </tr>`;
                            });
    
                            reportHtml += '</tbody></table>';
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
                    },
                    error: function() {
                        $('#report').html('<p class="text-red-500 dark:text-red-400">Erro ao carregar o relatório.</p>');
                    }
                });
            });
        });
    </script>
    
    
    
</x-layout>
