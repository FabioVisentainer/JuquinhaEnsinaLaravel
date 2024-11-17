<x-layout>
  <body class="body bg-slate-50">
    <nav class="flex justify-between items-center">
      <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
        <div class="max-[770px]:hidden">
          <!-- Div do botão de voltar -->
          <a href="{{ route('coordinators.registries.classessubjects.edit',  $classSubject->class_subject_id) }}">
            <img class="invertColor cursor-pointer pointer-events-auto" src="{{ asset('images/voltar.png') }}" alt="Botão de voltar a página" width="40px">
          </a>
        </div>
      </div>

      <!-- Div esquerda da navegação -->
      <div>
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
        <img class="hamburger invertColor cursor-pointer transition-all ease-out duration-500 md:hidden block max-[800px]:ml-3" src="{{ asset('images/hamburger.png') }}" alt="Hamburger" width="45px">
        <img class="x invertColor cursor-pointer hidden transition-all ease-linear duration-500 md:hidden max-[800px]:ml-3" src="{{ asset('images/x.png') }}" alt="Fechar menu hambúrguer" width="30px">
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

    <div class="total relative top-1 transition-all duration-300 ease-in-out flex justify-center items-center min-h-full p-4">
      <div class="w-full max-w-lg bg-gray-200 p-6 rounded-lg shadow-lg dark:bg-gray-800 border border-gray-300">
        <h1 class="text-3xl font-bold text-center mb-4 dark:text-white">Editar Conteúdo</h1>

        <form action="{{ route('coordinators.registries.classessubjects.syllabus.update', $syllabus->class_syllabus_id) }}" method="POST">
          @csrf
          @method('PUT')
          <!-- Incluir o componente de formulário para o conteúdo -->
          <x-registries.syllabus_form :syllabus="$syllabus" :classSubject="$classSubject" />

          <div class="flex justify-center">
            <button type="submit" class="btn bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-300">Editar Conteúdo</button>
          </div>
        </form>

        <x-errors />
      </div>
    </div>
  </body>
</x-layout>
