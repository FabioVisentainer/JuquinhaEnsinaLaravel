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
<x-layout>
    <div class="p-6 space-y-8 bg-gray-50 dark:bg-gray-800 min-h-screen">

        <!-- Link de Voltar -->
        <div class="flex justify-between items-center">
            {{-- <a href="{{ route('coordinators.reports.home') }}" class="text-blue-500 hover:underline">Voltar</a> --}}
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">Relatório de Alunos com Necessidades Especiais</h1>
        </div>
    
        <!-- Botão de Carregar Relatório -->
        <button id="load-special-students-report" class="bg-blue-500 text-white py-2 px-6 rounded-md shadow-md hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
            Carregar Relatório
        </button>
    
        <!-- Canvas para o Gráfico -->
        <div class="overflow-x-auto sm:overflow-hidden">
            <canvas id="specialNeedsChart" class="mx-auto mt-6 border-2 border-gray-300 rounded-lg w-full sm:w-[700px] h-[400px]"></canvas>
        </div>
    
        <!-- Relatório -->
        <div id="special-students-report" class="mt-8 space-y-6">
            <!-- Tabelas e outros conteúdos do relatório -->
    
            <!-- Tabela 1 com overflow -->
            <div class="overflow-x-auto sm:overflow-hidden">
                <table class="min-w-full bg-white dark:bg-gray-700 border border-gray-300 rounded-md shadow-md mt-4">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Necessidade Especial</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Conteúdo dinâmico será inserido aqui -->
                    </tbody>
                </table>
            </div>
    
            <!-- Tabela 2 com overflow -->
            <div class="overflow-x-auto sm:overflow-hidden">
                <table class="min-w-full bg-white dark:bg-gray-700 border border-gray-300 rounded-md shadow-md mt-4">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Necessidade Especial</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Turma</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Ano</th>
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
    
                        // Criação do gráfico de pizza
                        const labels = data.totalData.map(specialNeed => specialNeed.special_need_name);
                        const values = data.totalData.map(specialNeed => specialNeed.total_count);
                        createPieChart(labels, values);
    
                        // Tabela 1
                        reportHtml += '<h2 class="text-2xl font-semibold text-gray-800 dark:text-white">Total de Alunos com Necessidades Especiais</h2>';
                        reportHtml += '<div class="overflow-x-auto sm:overflow-hidden">';
                        reportHtml += '<table class="min-w-full bg-white dark:bg-gray-700 border border-gray-300 rounded-md shadow-md mt-4"><thead><tr><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Necessidade Especial</th><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Total</th></tr></thead><tbody>';
                        data.totalData.forEach(specialNeed => {
                            reportHtml += `<tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-600">
                                               <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${specialNeed.special_need_name}</td>
                                               <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${specialNeed.total_count}</td>
                                               </tr>`;
                        });
                        reportHtml += '</tbody></table>';
                        reportHtml += '</div>';
    
                        // Tabela 2
                        reportHtml += '<h2 class="text-2xl font-semibold text-gray-800 dark:text-white mt-8">Alunos com Necessidades Especiais por Turma</h2>';
                        reportHtml += '<div class="overflow-x-auto sm:overflow-hidden">';
                        reportHtml += '<table class="min-w-full bg-white dark:bg-gray-700 border border-gray-300 rounded-md shadow-md mt-4"><thead><tr><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Necessidade Especial</th><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Turma</th><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Ano</th><th class="px-4 py-2 text-left text-sm font-semibold text-gray-700 dark:text-white">Total</th></tr></thead><tbody>';
                        data.classData.forEach(classData => {
                            reportHtml += `<tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-600">
                                               <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${classData.special_need_name}</td>
                                               <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${classData.class_name}</td>
                                               <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${classData.class_year}</td>
                                               <td class="px-4 py-2 text-sm text-gray-700 dark:text-white">${classData.total_count}</td>
                                               </tr>`;
                        });
                        reportHtml += '</tbody></table>';
                        reportHtml += '</div>';
    
                        $('#special-students-report').html(reportHtml);
                    },
                    error: function() {
                        $('#special-students-report').html('<p class="text-red-500">Erro ao carregar o relatório.</p>');
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
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
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

</x-layout>
