<x-layout>
  <body class="body bg-slate-50">
    <nav class="flex justify-between items-center">
      <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
        <div class="max-[770px]:hidden">
          <!-- Div do botão de voltar -->
          <a href="{{ route('coordinators.registries.chronograms.home') }}">
            <img class="invertColor cursor-pointer pointer-events-auto" src="{{ asset('images/voltar.png') }}" alt="Botão de voltar à página" width="40px">
          </a>
        </div>
      </div>

      <!-- Div esquerda da nav -->
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
            <img id="notificationIcon" class="invertColor cursor-pointer" src="{{ asset('images/notificacao.png') }}" alt="Botão de notificações" width="40px">
          </a>
        </div>

        <div>
          <img src="{{ asset('images/skillos.png') }}" alt="Imagem da empresa" width="40px">
        </div>
      </div>
    </nav>

    <a href="{{ route('coordinators.registries.chronograms.home') }}">Voltar</a><br><br>

    <div class="total relative top-1 transition-all duration-300 ease-in-out flex justify-center items-center min-h-full p-4">
      <div class="w-full max-w-lg bg-gray-200 p-6 rounded-lg shadow-lg dark:bg-gray-800 border border-gray-300">
        <h1 class="text-3xl font-bold text-center mb-4 dark:text-white">Editar Cronograma: {{ $chronogram->chronogram_name }}</h1>

        <form action="{{ route('coordinators.registries.chronograms.update', $chronogram->chronogram_id) }}" method="POST">
          @csrf
          @method('PUT')

          <!-- Inclui o componente do formulário de cronograma e passa os dados do cronograma -->
          <x-registries.chronogram_form :chronogram="$chronogram" />

          <div class="flex justify-center mt-4">
            <button type="submit" class="btn bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-300">Atualizar Cronograma</button>
          </div>
        </form>
      </div>
    </div>

    <div class="total relative top-1 transition-all duration-300 ease-in-out">
      <h2 class="pageTitle text-4xl md:text-6xl mt-8">Tarefas Associadas</h2>

      @if($associatedHomeworks->isEmpty())
        <h2 class="text-xl text-center mt-4 text-black dark:text-white font-londrina">Nenhuma tarefa associada a este cronograma</h2>
      @else
        <div class="flex justify-center">
          <a href="{{ route('coordinators.select_homeworks', $chronogram->chronogram_id) }}" class="blueButton rounded-xl sm:w-[50%] md:w-[35%] lg:w-[20%] text-center">Selecionar Tarefa</a>
        </div>
        <div class="container mx-auto p-4 py-8">
          <div class="grid gap-4 p-4 bg-gray-200 rounded-xl w-full dark:bg-gray-800 mt-6">
            <!-- Adicionando overflow-x-auto para a rolagem lateral -->
            <div class="overflow-x-auto w-full">
              <table class="min-w-full bg-white dark:bg-gray-700 rounded-lg shadow overflow-hidden">
                <thead>
                  <tr class="bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-white">
                    <th class="py-3 px-6 text-left font-medium">Nome da Tarefa</th>
                    <th class="py-3 px-6 text-left font-medium">Data de Lançamento</th>
                    <th class="py-3 px-6 text-left font-medium">Data de Entrega</th>
                    <th class="py-3 px-6 text-left font-medium">Ações</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($associatedHomeworks as $associatedHomework)
                    <tr class="border-b dark:border-gray-600 dark:text-white">
                      <td class="py-3 px-6">{{ $associatedHomework->homework_name }}</td>
                      <td class="py-3 px-6">{{ $associatedHomework->pivot->release_date }}</td>
                      <td class="py-3 px-6">{{ $associatedHomework->pivot->due_date }}</td>
                      <td class="py-3 px-6">
                        <form action="{{ route('coordinators.delete_homework', [$chronogram->chronogram_id, $associatedHomework->homework_id]) }}" method="POST" class="inline">
                          @csrf
                          @method('DELETE')
                          <button type="submit" class="text-red-500 hover:text-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">Remover</button>
                        </form>
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      @endif
    </div>
  </body>
</x-layout>
