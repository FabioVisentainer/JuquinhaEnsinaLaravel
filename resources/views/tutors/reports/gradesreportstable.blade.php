<x-layout>
    <body class="body bg-slate-50">
        <nav class="flex justify-between items-center">
            <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
                <div class="max-[770px]:hidden">
                    <!-- Div do botao de voltar -->
                    <a href="{{ route('tutors.reports.home', [$studentUserId]) }}">
                        <img class="invertColor cursor-pointer pointer-events-auto" src="{{ asset('images/voltar.png') }}" alt="Botao de voltar a pagina" width="40px">
                    </a>
                </div>
            </div>

            <!-- Div esquerda da nav -->
            <div>
                <ul class="navText opacity-0 top-[120px] gap-4 sm:pointer-events-auto pointer-events-none">
                    <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
                        <a href="{{ route('tutors.home') }}">
                            <p class="navTitle">Inicio</p>
                        </a>
                    </li>
                    <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
                        <a href="{{ route('tutors.homework.table', [$studentUserId]) }}">
                            <p class="navTitle">Atividades</p>
                        </a>
                    </li>
                    <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
                        <a href="{{ route('tutors.activity.table', [$studentUserId]) }}">
                            <p class="navTitle">Tarefas</p>
                        </a>
                    </li>
                    <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
                        <a href="{{ route('tutors.reports.home', [$studentUserId]) }}">
                            <p class="navTitle">Desempenho</p>
                        </a>
                    </li>
                    <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
                        <a href="{{ route('tutors.videos.home', [$studentUserId]) }}">
                            <p class="navTitle">Vídeos</p>
                        </a>
                    </li>
                    <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
                        <a href="{{ route('tutors.grades.table', [$studentUserId]) }}">
                            <p class="navTitle">Boletim</p>
                        </a>
                    </li>
                </ul>
            </div>
            
            <div>
                <img class="hamburger invertColor cursor-pointer transition-all ease-out duration-500 md:hidden block max-[800px]:ml-3" src="{{ asset('images/hamburger.png') }}" alt="Hamburger" width="45px">
                <img class="x invertColor cursor-pointer hidden transition-all ease-linear duration-500 md:hidden max-[800px]:ml-3" src="{{ asset('images/x.png') }}" alt="Exit hamburguer" width="30px">
            </div>

            <!-- Icones de navegação à direita -->
            <div class="flex gap-8 p-5">
                <div>
                    <img class="moon cursor-pointer drop-shadow-[0_0px_16px_rgba(4,15,140)]" src="{{ asset('images/lua.png') }}" alt="Botão Lua" width="40px">
                    <img class="sun cursor-pointer dark:drop-shadow-[0_0px_30px_rgba(255,232,150)] hidden" src="{{ asset('images/sol.png') }}" alt="Botão Sol" width="40px">
                </div>
                <div>
                    <a href="{{ route('tutors.notifications.home', [$studentUserId]) }}">
                        <img id="notificationIcon" class="invertColor cursor-pointer" src="{{ asset('images/notificacao.png') }}" alt="Botao de notificacoes" width="40px">
                    </a>
                </div>
                <div>
                    <img src="{{ asset('images/skillos.png') }}" alt="Company image" width="40px">
                </div>
            </div>
        </nav>

        <div class="p-6 space-y-8 bg-gray-50 dark:bg-gray-800 min-h-screen">
            <!-- Título do Relatório -->
            <div class="flex justify-between items-center">
              <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Relatório de Notas</h1>
            </div>
          
            <!-- Botão para carregar o relatório -->
            <button id="load-grades-report" class="bg-blue-500 text-white py-2 px-6 rounded-md shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
              Carregar Relatório
            </button>
          
            <!-- Container para o gráfico -->
            <div id="chartContainer" class="mt-6 w-full" style="height: 370px;"></div>
          
            <!-- Filtro de Avaliação -->
            <div id="evaluation-filter-container" class="mt-4"></div>
          
            <!-- Relatório de Notas -->
            <div id="grades-report" class="mt-8 space-y-6"></div>
          </div>
          
          <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
          <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
          
          <script>
            $(document).ready(function() {
              let gradesData = [];
          
              $('#load-grades-report').click(function() {
                $.ajax({
                  url: '{{ route("tutors.fetchGradesData", [$studentUserId]) }}',
                  type: 'GET',
                  success: function(data) {
                    let reportHtml = '';
                    gradesData = data.class; // Save class grades data for chart use
          
                    // Populate dropdown for evaluation filter
                    let evaluationOptions = [...new Set(data.class.map(item => item.evaluation_number))];
                    let filterHtml = '<label for="evaluationFilter" class="text-lg font-semibold text-gray-800 dark:text-white">Selecione a Avaliação: </label>';
                    filterHtml += '<select id="evaluationFilter" class="mt-2 bg-white dark:bg-gray-700 text-gray-700 dark:text-white border border-gray-300 rounded-md shadow-sm w-full py-2 px-4">';
                    filterHtml += '<option value="all">Todas</option>';
                    evaluationOptions.forEach(evaluation => {
                      filterHtml += `<option value="${evaluation}">Avaliação ${evaluation}</option>`;
                    });
                    filterHtml += '</select>';
                    $('#evaluation-filter-container').html(filterHtml);
          
                    // Render the chart
                    renderChart('all');
          
                    // Handle filter change
                    $('#evaluationFilter').change(function() {
                      renderChart($(this).val());
                    });
          
                    // Grades by Class
                    reportHtml += '<h2 class="text-2xl font-semibold text-gray-800 dark:text-white mt-6">Notas por Turma</h2>';
                    reportHtml += '<div class="overflow-x-auto"><table class="min-w-full bg-white dark:bg-gray-700 border border-gray-300 rounded-md shadow-md mt-4"><thead><tr><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Turma</th><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Ano</th><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Avaliação</th><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Média</th></tr></thead><tbody>';
                    data.class.forEach(cls => {
                      reportHtml += `<tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-600">
                                       <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${cls.class_name}</td>
                                       <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${cls.class_year}</td>
                                       <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${cls.evaluation_number}</td>
                                       <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${cls.media}</td>
                                     </tr>`;
                    });
                    reportHtml += '</tbody></table></div>';
          
                    // Grades by Subject
                    reportHtml += '<h2 class="text-2xl font-semibold text-gray-800 dark:text-white mt-8">Notas por Disciplina</h2>';
                    reportHtml += '<div class="overflow-x-auto"><table class="min-w-full bg-white dark:bg-gray-700 border border-gray-300 rounded-md shadow-md mt-4"><thead><tr><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Turma</th><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Ano</th><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Avaliação</th><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Disciplina</th><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Média</th></tr></thead><tbody>';
                    data.subject.forEach(subject => {
                      reportHtml += `<tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-600">
                                       <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${subject.class_name}</td>
                                       <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${subject.class_year}</td>
                                       <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${subject.evaluation_number}</td>
                                       <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${subject.class_subject_name}</td>
                                       <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${subject.media}</td>
                                     </tr>`;
                    });
                    reportHtml += '</tbody></table></div>';
          
                    $('#grades-report').html(reportHtml);
                  },
                  error: function() {
                    $('#grades-report').html('<p class="text-red-500">Erro ao carregar o relatório.</p>');
                  }
                });
              });
          
              function renderChart(evaluationNumber) {
                let chartData = gradesData
                  .filter(item => evaluationNumber === 'all' || item.evaluation_number == evaluationNumber)
                  .map(item => ({
                    label: item.class_name,
                    y: parseFloat(item.media)
                  }));
          
                let chart = new CanvasJS.Chart("chartContainer", {
                  animationEnabled: true,
                  theme: "light2",
                  title: { text: "Média das Turmas por Avaliação" },
                  axisY: { title: "Média" },
                  data: [{
                    type: "column",
                    dataPoints: chartData
                  }]
                });
          
                chart.render();
              }
            });
          </script>
</x-layout>
