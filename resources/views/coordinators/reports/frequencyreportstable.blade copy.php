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