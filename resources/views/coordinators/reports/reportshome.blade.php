<x-layout>
  <body class="body bg-slate-50">
      <nav class="flex justify-between items-center">
          <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
              <div class="max-[770px]:hidden">
                  <!-- Botão de voltar -->
                  <a href="{{ route('coordinators.home') }}">
                      <img class="invertColor cursor-pointer pointer-events-auto" src="{{ asset('images/voltar.png') }}" alt="Botão de voltar à página" width="40px">
                  </a>
              </div>
          </div>

          <!-- Div esquerda da navegação -->
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

          <!-- Ícones de navegação mobile -->
          <div>
              <img class="hamburger invertColor cursor-pointer transition-all ease-out duration-500 md:hidden block max-[800px]:ml-3" src="{{ asset('images/hamburger.png') }}" alt="Ícone do menu" width="45px">
              <img class="x invertColor cursor-pointer hidden transition-all ease-linear duration-500 md:hidden max-[800px]:ml-3" src="{{ asset('images/x.png') }}" alt="Fechar menu" width="30px">
          </div>

          <div class="flex gap-8 p-5">
              <!-- Div direita da navegação -->
              <div>
                  <img class="moon cursor-pointer drop-shadow-[0_0px_16px_rgba(4,15,140)]" src="{{ asset('images/lua.png') }}" alt="Ícone de lua" width="40px">
                  <img class="sun cursor-pointer dark:drop-shadow-[0_0px_30px_rgba(255,232,150)] hidden" src="{{ asset('images/sol.png') }}" alt="Ícone de sol" width="40px">
              </div>

              <div>
                  <a href="{{ route('coordinators.notifications.home') }}">
                      <img id="notificationIcon" class="invertColor cursor-pointer" src="{{ asset('images/notificacao.png') }}" alt="Botão de notificações" width="40px">
                  </a>
              </div>

              <div>
                  <img src="{{ asset('images/skillos.png') }}" alt="Logo da empresa" width="40px">
              </div>
          </div>
      </nav>

      <main>
          <div class="total relative top-1 transition-all duration-300 ease-in-out">
              <div>
                  <h1 class="pageTitle text-4xl md:text-6xl">Relatórios de desempenho</h1>
              </div>
              <div class="contCenter">
                  <a href="{{ route('coordinators.frequencyreports.table') }}" class="block p-4 mb-4 text-white bg-blue-500 rounded-lg shadow-lg hover:bg-blue-600 transition duration-300 ease-in-out transform hover:scale-105 w-auto max-w-xs mx-auto">
                      Frequência
                  </a>
                  <a href="{{ route('coordinators.gradesreports.table') }}" class="block p-4 mb-4 text-white bg-green-500 rounded-lg shadow-lg hover:bg-green-600 transition duration-300 ease-in-out transform hover:scale-105 w-auto max-w-xs mx-auto">
                      Média
                  </a>
                  <a href="{{ route('coordinators.activitiesreport.table') }}" class="block p-4 mb-4 text-white bg-yellow-500 rounded-lg shadow-lg hover:bg-yellow-600 transition duration-300 ease-in-out transform hover:scale-105 w-auto max-w-xs mx-auto">
                      Atividade Mais Jogadas
                  </a>
                  <a href="{{ route('coordinators.sstudentsreport.table') }}" class="block p-4 mb-4 text-white bg-red-500 rounded-lg shadow-lg hover:bg-red-600 transition duration-300 ease-in-out transform hover:scale-105 w-auto max-w-xs mx-auto">
                      Alunos com Portabilidade
                  </a>
              </div>
          </div>
      </main>
  </body>
</x-layout>
