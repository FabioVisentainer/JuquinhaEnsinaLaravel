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