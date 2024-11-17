<x-layout>
  <body class="body bg-slate-50">
    <nav class="flex justify-between items-center">
      <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
        <div class="max-[770px]:hidden">
          <!-- Div do botão de voltar -->
          <a href="{{ route('Mainhome') }}">
            <img class="invertColor cursor-pointer pointer-events-auto" src="{{ asset('images/voltar.png') }}" alt="Botão de voltar a página" width="40px">
          </a>
        </div>
      </div>

      <!-- Div esquerda da navegação -->
      <div class="">
        <ul class="navText opacity-0 top-[120px] gap-4 sm:pointer-events-auto pointer-events-none">
          <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
            <a href="{{ route('teachers.home') }}">
              <p class="navTitle">Início</p>
            </a>
          </li>
          <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
            <a href="{{ route('teachers.activity.home') }}">
              <p class="navTitle">Liberar Atividades</p>
            </a>
          </li>
          <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
            <a href="{{ route('teachers.homework.home') }}">
              <p class="navTitle">Liberar Tarefas</p>
            </a>
          </li>
          <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
            <a href="{{ route('teachers.frequency.home') }}">
              <p class="navTitle">Registrar Frequência</p>
            </a>
          </li>
          <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
            <a href="{{ route('teachers.grades.home') }}">
              <p class="navTitle">Registrar Boletim</p>
            </a>
          </li>
          <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
            <a href="{{ route('teachers.videos.home') }}">
              <p class="navTitle">Enviar Vídeos</p>
            </a>
          </li>
        </ul>
      </div>

      <div>
        <img class="hamburger invertColor cursor-pointer transition-all ease-out duration-500 md:hidden block max-[800px]:ml-3" src="../images/hamburger.png" alt="Hamburger" width="45px">
        <img class="x invertColor cursor-pointer hidden transition-all ease-linear duration-500 md:hidden max-[800px]:ml-3" src="../images/x.png" alt="Exit hamburger" width="30px">
      </div>

      <div class="flex gap-8 p-5">
        <!-- Div direita da navegação -->
        <div>
          <img class="moon cursor-pointer drop-shadow-[0_0px_16px_rgba(4,15,140)]" src="../images/lua.png" alt="Ícone da lua" width="40px">
          <img class="sun cursor-pointer dark:drop-shadow-[0_0px_30px_rgba(255,232,150)] hidden" src="../images/sol.png" alt="Ícone do sol" width="40px">
        </div>

        <div>
          <img src="../images/skillos.png" alt="Imagem da empresa" width="40px">
        </div>
      </div>
    </nav>

    <main>
      <div class="total relative top-1 transition-all duration-300 ease-in-out">
        <div>
          <h1 class="pageTitle">Olá Professor(a)!</h1>
        </div>
        <div class="dadCards">
          <div class="card bg-[#FFEEB1] drop-shadow-2xl dark:drop-shadow-[0_0px_30px_rgba(255,232,150,0.5)]">
            <a href="{{ route('teachers.activity.home') }}">
              <img class="p-8" src="../images/atividades.png" alt="Ícone de atividades" width="350px">
              <p class="text-4xl p-2 sm:text-4xl">Liberar Atividades</p>
            </a>
          </div>

          <div class="card bg-[#C5B9EF] drop-shadow-2xl dark:drop-shadow-[0_0px_30px_rgba(148,119,252,0.5)]">
            <a href="{{ route('teachers.homework.home') }}">
              <img class="p-8" src="../images/tarefas.png" alt="Ícone de tarefas" width="350px">
              <p class="text-4xl p-2 sm:text-4xl">Liberar Tarefas</p>
            </a>
          </div>

          <div class="card bg-[#BEF1EE] drop-shadow-2xl dark:drop-shadow-[0_0px_30px_rgba(176,255,250,0.5)]">
            <a href="{{ route('teachers.frequency.home') }}">
              <img class="p-8" src="../images/frequencia.png" alt="Ícone de frequência" width="350px">
              <p class="text-4xl p-2 sm:text-4xl">Registrar Frequência</p>
            </a>
          </div>

          <div class="card bg-[#FFB1B2] drop-shadow-2xl dark:drop-shadow-[0_0px_30px_rgba(255, 0, 0)]">
            <a href="{{ route('teachers.grades.home') }}">
              <img class="p-8" src="../images/boletim.png" alt="Ícone de boletim" width="350px">
              <p class="text-4xl p-2 sm:text-4xl">Registrar Boletim</p>
            </a>
          </div>

          <div class="card bg-[#B9CAEF] drop-shadow-2xl dark:drop-shadow-[0_0px_30px_rgba(0, 102, 204, 0.5)]">
            <a href="{{ route('teachers.videos.home') }}">
              <img class="p-8" src="../images/videos(blue).png" alt="Ícone de vídeos" width="350px">
              <p class="text-4xl p-2 sm:text-4xl">Enviar Vídeos</p>
            </a>
          </div>

        </div>
      </div>
    </main>
  </body>
</x-layout>
