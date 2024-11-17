<x-layout>
  <body class="body bg-slate-50">
    <nav class="flex justify-between items-center">
      <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
        <div class="max-[770px]:hidden">
          <!-- Div do botão de voltar -->
          <a href="{{ route('coordinators.registries.classessubjects.home') }}">
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

      <!-- Ícones de navegação -->
      <div>
        <img class="hamburger invertColor cursor-pointer transition-all ease-out duration-500 md:hidden block max-[800px]:ml-3" src="{{ asset('images/hamburger.png') }}" alt="Ícone de menu" width="45px">
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

    <div class="container mx-auto p-6">
      <h1 class="pageTitle text-4xl md:text-6xl text-center mb-6">Editar Disciplina</h1>
      <div class="contCenter flex justify-center">
        <form action="{{ route('coordinators.registries.classessubjects.update', $classSubject->class_subject_id) }}" method="POST" class="form bg-gray-100 dark:bg-gray-800 p-6 rounded-lg shadow-md">
          @csrf
          @method('PUT')

          <x-registries.class_subjects_form :classSubject="$classSubject" />

          <div class="flex justify-center mt-6">
            <button type="submit" class="blueButton rounded-xl px-8 py-3">Atualizar Disciplina</button>
          </div>
        </form>

        <h2 class="text-5xl text-center text-gray-700 dark:text-gray-300 mt-10 mb-4 font-londrina">Conteúdo Programático</h2>

        <div class="flex justify-center">
          <a href="{{ route('coordinators.registries.classessubjects.syllabus.create', $classSubject->class_subject_id) }}">
            <button class="bg-blue-500 text-white px-6 py-2 rounded-xl hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 font-londrina">Adicionar Novo Conteúdo</button>
          </a>
        </div>

        @if($syllabus->isNotEmpty())
          <div class="container mx-auto p-4 py-8 mt-2">
            <div class="grid gap-4 bg-gray-200 rounded-lg w-full dark:bg-gray-800 p-4">
              @foreach($syllabus as $syllabi)
                <div class="bg-white p-4 rounded-lg shadow flex flex-col md:flex-row md:justify-between items-start md:items-center dark:bg-gray-700">
                  <div class="flex flex-col">
                    <span class="text-2xl font-semibold dark:text-white">{{ $syllabi->class_syllabus_name }}</span>
                    <p class="mt-1 text-gray-600 text-lg dark:text-gray-300">{{ $syllabi->class_syllabus_description }}</p>
                    <span class="text-sm mt-1 {{ $syllabi->is_active ? 'text-green-500 dark:text-green-400' : 'text-red-500 dark:text-red-400' }}">
                      {{ $syllabi->is_active ? '(Ativo)' : '(Inativo)' }}
                    </span>
                  </div>
                  <a href="{{ route('coordinators.registries.classessubjects.syllabus.edit', $syllabi->class_syllabus_id) }}" class="mt-4 md:mt-0">
                    <button class="w-full md:w-36 min-w-[150px] flex items-center justify-center bg-blue-500 text-white rounded-xl hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 py-3 mb-3">
                      Editar
                    </button>
                  </a>
                </div>
              @endforeach
            </div>
          </div>
        @else
          <p class="mt-8 text-2xl text-gray-700 dark:text-gray-300 text-center">Nenhum conteúdo adicionado ainda.</p>
        @endif
      </div>
    </div>
    
    <x-errors />
  </body>
</x-layout>
