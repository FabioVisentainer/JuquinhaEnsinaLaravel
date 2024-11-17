<x-layout>
  <body class="body bg-slate-50">
    <nav class="flex justify-between items-center">
      <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
        <div class="max-[770px]:hidden">
          <!-- Div do botão de voltar -->
          <a href="{{ route('Mainhome') }}"><img class="invertColor cursor-pointer pointer-events-auto" src="{{ asset('images/voltar.png') }}" alt="Botão de voltar a página" width="40px"></a>
        </div>
      </div>

      <!-- Div esquerda da navegação -->
      <div class="">
        <ul class="navText opacity-0 top-[120px] gap-4 sm:pointer-events-auto pointer-events-none">
          <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
            <a href="{{ route('coordinators.home') }}"><p class="navTitle">Início</p></a>
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
        <img class="hamburger invertColor cursor-pointer transition-all ease-out duration-500 md:hidden block max-[800px]:ml-3" src="../images/hamburger.png" alt="Hamburger" width="45px">
        <img class="x invertColor cursor-pointer hidden transition-all ease-linear duration-500 md:hidden max-[800px]:ml-3" src="../images/x.png" alt="Fechar hamburger" width="30px">
      </div>

      <div class="flex gap-8 p-5">
        <!-- Div direita da navegação -->
        <div>
          <img class="moon cursor-pointer drop-shadow-[0_0px_16px_rgba(4,15,140)]" src="../images/lua.png" alt="Ícone da lua" width="40px">
          <img class="sun cursor-pointer dark:drop-shadow-[0_0px_30px_rgba(255,232,150)] hidden" src="../images/sol.png" alt="Ícone do sol" width="40px">
        </div>

        <div>
          <a href="{{ route('coordinators.notifications.home') }}">
            <img id="notificationIcon" class="invertColor cursor-pointer" src="{{ asset('images/notificacao.png') }}" alt="Botão de notificações" width="40px">
          </a>
        </div>

        <div>
          <img src="../images/skillos.png" alt="Imagem da empresa" width="40px">
        </div>
      </div>
    </nav>

    <main>
      <div class="total relative top-1 transition-all duration-300 ease-in-out">
        <div>
          <h1 class="pageTitle">Olá Coordenador!</h1>
        </div>
        <div class="dadCards">
          <div class="card bg-[#FFEEB1] drop-shadow-2xl dark:drop-shadow-[0_0px_30px_rgba(255,232,150,0.5)]">
            <a href="{{ route('coordinators.registries.home') }}">
              <img class="p-8" src="{{ asset('images/cordCadastro.png') }}" alt="Imagem de cadastros" width="350px">
              <p class="text-3xl p-2 sm:text-4xl">Cadastros</p>
            </a>
          </div>

          <div class="card bg-[#C5B9EF] drop-shadow-2xl dark:drop-shadow-[0_0px_30px_rgba(148,119,252,0.5)]">
            <a href="{{ route('coordinators.registries.classes.home') }}">
              <img class="p-8" src="{{ asset('images/turma.png') }}" alt="Imagem de turmas" width="350px">
              <p class="text-3xl p-2 sm:text-4xl">Turmas</p>
            </a>
          </div>

          <div class="card bg-[#BEF1EE] drop-shadow-2xl dark:drop-shadow-[0_0px_30px_rgba(176,255,250,0.5)]">
            <a href="{{ route('coordinators.registries.classessubjects.home') }}">
              <img class="p-8" src="{{ asset('images/disciplinas.png') }}" alt="Imagem de disciplinas" width="350px">
              <p class="text-3xl p-2 sm:text-4xl">Disciplinas</p>
            </a>
          </div>

          <div class="card bg-[#FFB1B2] drop-shadow-2xl dark:drop-shadow-[0_0px_30px_rgba(255, 0, 0)]">
            <a href="{{ route('coordinators.registries.chronograms.home') }}">
              <img class="p-8" src="{{ asset('images/cronograma.png') }}" alt="Imagem de cronograma" width="350px">
              <p class="text-2xl p-2 sm:text-3xl">Cronogramas de Ensino</p>
            </a>
          </div>

          <div class="card bg-[#B9CAEF] drop-shadow-2xl dark:drop-shadow-[0_0px_30px_rgba(0, 102, 204, 0.5)]">
            <a href="{{ route('coordinators.reports.home') }}">
              <img class="p-8" src="{{ asset('images/CordRelatorio.png') }}" alt="Imagem de relatórios" width="350px">
              <p class="text-2xl p-2 sm:text-3xl">Relatórios de Desempenho</p>
            </a>
          </div>
        </div>
      </div>
    </main>
  </body>
</x-layout>
