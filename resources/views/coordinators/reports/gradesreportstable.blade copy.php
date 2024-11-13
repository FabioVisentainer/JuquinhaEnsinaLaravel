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






    
    <h1>Relatório de Notas</h1>
    <button id="load-grades-report">Carregar Relatório</button>
    <div id="grades-report" style="margin-top: 20px;"></div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#load-grades-report').click(function() {
                $.ajax({
                    url: '{{ route("coordinators.fetchGradesData") }}',
                    type: 'GET',
                    success: function(data) {
                        let reportHtml = '';

                        // Grades by Class
                        reportHtml += '<h2>Notas por Turma</h2>';
                        reportHtml += '<table border="1"><tr><th>Turma</th><th>Ano</th><th>Avaliação</th><th>Média</th></tr>';
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

                        // Grades by Student
                        reportHtml += '<h2>Notas por Aluno</h2>';
                        reportHtml += '<table border="1"><tr><th>Aluno</th><th>Turma</th><th>Ano</th><th>Avaliação</th><th>Disciplina</th><th>Média</th></tr>';
                        data.student.forEach(student => {
                            reportHtml += `<tr><td>${student.student_name}</td><td>${student.class_name}</td><td>${student.class_year}</td><td>${student.evaluation_number}</td><td>${student.class_subject_name}</td><td>${student.media}</td></tr>`;
                        });
                        reportHtml += '</table>';

                        $('#grades-report').html(reportHtml);
                    },
                    error: function() {
                        $('#grades-report').html('<p>Erro ao carregar o relatório.</p>');
                    }
                });
            });
        });
    </script>
</x-layout>