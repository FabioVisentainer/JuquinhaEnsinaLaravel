<x-layout>
    <body class="body bg-slate-50">
      <nav class="flex justify-between items-center">
        <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
          <div class="max-[770px]:hidden">
            <!-- Div do botão de voltar -->
            <a href="{{ route('coordinators.reports.home') }}">
              <img class="invertColor cursor-pointer pointer-events-auto" src="{{ asset('images/voltar.png') }}" alt="Botão de voltar à página" width="40px">
            </a>
          </div>
        </div>
  
        <!-- Div esquerda da navegação -->
        <div class="">
          <ul class="navText opacity-0 top-[120px] gap-4 sm:pointer-events-auto pointer-events-none">
            <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
              <a href="{{ route('coordinators.home') }}">
                <p class="navTitle">Início</p>
              </a>
            </li>
            <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
              <a href="{{ route('coordinators.registries.home') }}">
                <p class="navTitle">Cadastros</p>
              </a>
            </li>
            <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
              <a href="{{ route('coordinators.registries.classes.home') }}">
                <p class="navTitle">Turmas</p>
              </a>
            </li>
            <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
              <a href="{{ route('coordinators.registries.classessubjects.home') }}">
                <p class="navTitle">Disciplinas</p>
              </a>
            </li>
            <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
              <a href="{{ route('coordinators.registries.chronograms.home') }}">
                <p class="navTitle">Cronogramas</p>
              </a>
            </li>
            <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
              <a href="{{ route('coordinators.reports.home') }}">
                <p class="navTitle">Relatórios</p>
              </a>
            </li>
          </ul>
        </div>
  
        <div>
          <img class="hamburger invertColor cursor-pointer transition-all ease-out duration-500 md:hidden block max-[800px]:ml-3" src="{{ asset('images/hamburger.png') }}" alt="Hamburger" width="45px">
          <img class="x invertColor cursor-pointer hidden transition-all ease-linear duration-500 md:hidden max-[800px]:ml-3" src="{{ asset('images/x.png') }}" alt="Fechar menu" width="30px">
        </div>
  
        <div class="flex gap-8 p-5">
          <!-- Div direita da navegação -->
          <div>
            <img class="moon cursor-pointer drop-shadow-[0_0px_16px_rgba(4,15,140)]" src="{{ asset('images/lua.png') }}" alt="" width="40px">
            <img class="sun cursor-pointer dark:drop-shadow-[0_0px_30px_rgba(255,232,150)] hidden" src="{{ asset('images/sol.png') }}" alt="" width="40px">
          </div>
  
          <div>
            <a href="{{ route('coordinators.notifications.home') }}">
              <img id="notificationIcon" class="invertColor cursor-pointer" src="{{ asset('images/notificacao.png') }}" alt="Botão de notificações" width="40px">
            </a>
          </div>
  
          <div>
            <img src="{{ asset('images/skillos.png') }}" alt="Imagem da empresa" width="40px">
          </div>
        </div>
      </nav>
  
      <div class="p-6 space-y-8 bg-gray-50 dark:bg-gray-800 min-h-screen">
        <!-- Título do relatório -->
        <div class="flex justify-between items-center">
          <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Relatório de Notas</h1>
        </div>
  
        <!-- Botão para carregar o relatório -->
        <button id="load-grades-report" class="bg-blue-500 text-white py-2 px-6 rounded-md shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
          Carregar Relatório
        </button>
  
        <!-- Canvas para o gráfico -->
        <div class="mt-6 relative w-full">
          <canvas id="gradesBarChart" class="mx-auto border-2 border-gray-300 rounded-lg w-full h-auto"></canvas>
        </div>
  
        <!-- Relatório de Notas por Turma, Disciplina e Aluno -->
        <div id="grades-report" class="mt-8 space-y-6"></div>
      </div>
  
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
  
                // Filtro por Ano
                reportHtml += '<h2 class="text-2xl font-semibold text-gray-800 dark:text-white mt-6">Filtrar por Ano:</h2>';
                reportHtml += '<select id="yearFilter" class="mt-2 bg-white dark:bg-gray-700 text-gray-700 dark:text-white border border-gray-300 rounded-md shadow-sm w-full py-2 px-4">';
                reportHtml += '<option value="">Selecione um ano</option>';
                const uniqueYears = [...new Set(data.class.map(cls => cls.class_year))];
                uniqueYears.forEach(year => {
                  reportHtml += `<option value="${year}">${year}</option>`;
                });
                reportHtml += '</select>';
  
                // Notas por Turma
                reportHtml += '<h2 class="text-2xl font-semibold text-gray-800 dark:text-white mt-8">Notas por Turma</h2>';
                reportHtml += '<div class="overflow-x-auto"><table class="min-w-full bg-white dark:bg-gray-700 border border-gray-300 rounded-md shadow-md mt-4"><thead><tr><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Turma</th><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Ano</th><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Atividade</th><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Média</th></tr></thead><tbody>';
                data.class.forEach(cls => {
                  reportHtml += `<tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-600">
                                   <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${cls.class_name}</td>
                                   <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${cls.class_year}</td>
                                   <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${cls.evaluation_number}</td>
                                   <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${cls.media}</td>
                                 </tr>`;
                });
                reportHtml += '</tbody></table></div>';
  
                // Notas por Disciplina
                reportHtml += '<h2 class="text-2xl font-semibold text-gray-800 dark:text-white mt-8">Notas por Disciplina</h2>';
                reportHtml += '<div class="overflow-x-auto"><table class="min-w-full bg-white dark:bg-gray-700 border border-gray-300 rounded-md shadow-md mt-4"><thead><tr><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Turma</th><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Ano</th><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Avaliação</th><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Disciplina</th><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Média</th></tr></thead><tbody>';
                data.subject.forEach(subject => {
                  reportHtml += `<tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-600">
                                   <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${subject.class_name}</td>
                                   <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${subject.class_year}</td>
                                   <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${subject.evaluation_number}</td>
                                   <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${subject.subject_name}</td>
                                   <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${subject.media}</td>
                                 </tr>`;
                });
                reportHtml += '</tbody></table></div>';
  
                // Notas por Aluno
                reportHtml += '<h2 class="text-2xl font-semibold text-gray-800 dark:text-white mt-8">Notas por Aluno</h2>';
                reportHtml += '<div class="overflow-x-auto"><table class="min-w-full bg-white dark:bg-gray-700 border border-gray-300 rounded-md shadow-md mt-4"><thead><tr><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Aluno</th><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Turma</th><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Ano</th><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Disciplina</th><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Média</th></tr></thead><tbody>';
                data.student.forEach(student => {
                  reportHtml += `<tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-600">
                                   <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${student.student_name}</td>
                                   <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${student.class_name}</td>
                                   <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${student.class_year}</td>
                                   <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${student.subject_name}</td>
                                   <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${student.media}</td>
                                 </tr>`;
                });
                reportHtml += '</tbody></table></div>';
  
                // Atualizar o conteúdo da página
                $('#grades-report').html(reportHtml);
  
                // Gerar gráfico de barras
                generateBarChart(data.class);
              }
            });
          });
  
          function generateBarChart(classData) {
            const ctx = document.getElementById('gradesBarChart').getContext('2d');
            const labels = classData.map(cls => cls.class_name);
            const dataValues = classData.map(cls => cls.media);
  
            if (chart) {
              chart.destroy();
            }
  
            chart = new Chart(ctx, {
              type: 'bar',
              data: {
                labels: labels,
                datasets: [{
                  label: 'Média das Notas',
                  data: dataValues,
                  backgroundColor: 'rgba(54, 162, 235, 0.2)',
                  borderColor: 'rgba(54, 162, 235, 1)',
                  borderWidth: 1
                }]
              },
              options: {
                responsive: true,
                scales: {
                  y: {
                    beginAtZero: true
                  }
                }
              }
            });
          }
        });
      </script>
    </body>
  </x-layout>
  