<x-layout>
  <body class="body bg-slate-50">
      <nav class="flex justify-between items-center">
          <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
              <div class="max-[770px]:hidden">
                  <!-- Div do botão de voltar -->
                  <a href="{{ route('coordinators.registries.chronograms.edit', $chronogram->chronogram_id) }}">
                      <img class="invertColor cursor-pointer pointer-events-auto" src="{{ asset('images/voltar.png') }}" alt="Botão de voltar a página" width="40px">
                  </a>
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
              <img class="hamburger invertColor cursor-pointer transition-all ease-out duration-500 md:hidden block max-[800px]:ml-3" src="{{ asset('images/hamburger.png') }}" alt="Hamburger" width="45px">
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
      
      <div class="total relative top-1 transition-all duration-300 ease-in-out">
          <h1 class="pageTitle text-4xl md:text-6xl mt-4">Selecione tarefas para o cronograma: {{ $chronogram->chronogram_name }}</h1>
      
          @if ($errors->any())
              <div class="alert alert-danger mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                  <ul>
                      @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                      @endforeach
                  </ul>
              </div>
          @endif
      
          <div class="container mx-auto p-4 py-8">
              <form action="{{ route('coordinators.save_homeworks', $chronogram->chronogram_id) }}" method="POST" class="space-y-4">
                  @csrf
      
                  <div id="homeworkList" class="grid gap-4 p-4 bg-gray-200 rounded-lg w-full dark:bg-gray-800 mt-6">
                      <div class="homework bg-white p-4 rounded-lg shadow flex flex-col dark:bg-gray-700 overflow-x-auto">
                          <table class="w-full">
                              <thead>
                                  <tr class="border-b-2 border-gray-300 dark:border-gray-600">
                                      <th class="text-left p-2 text-gray-800 dark:text-white">Selecionar</th>
                                      <th class="text-left p-2 text-gray-800 dark:text-white">Nome da Tarefa</th>
                                      <th class="text-left p-2 text-gray-800 dark:text-white">URL da Tarefa</th>
                                      <th class="text-left p-2 text-gray-800 dark:text-white">Data de Postagem</th>
                                      <th class="text-left p-2 text-gray-800 dark:text-white">Data de Entrega</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach($homeworks as $homework)
                                      @php
                                          $associatedHomework = $associatedHomeworks->firstWhere('homework_id', $homework->homework_id);
                                      @endphp
              
                                      <tr class="border-b border-gray-300 dark:border-gray-600">
                                          <td class="p-2 text-center">
                                              <input type="checkbox" name="homeworks[]" value="{{ $homework->homework_id }}" 
                                                  {{ $associatedHomework ? 'checked' : '' }}
                                                  onchange="toggleDateFields({{ $homework->homework_id }})"
                                                  class="form-checkbox h-5 w-5 text-blue-600 dark:bg-gray-800 dark:border-gray-600 focus:ring-blue-500">
                                          </td>
                                          <td class="p-2 text-gray-700 dark:text-gray-300">{{ $homework->homework_name }}</td>
                                          <td class="p-2 text-gray-700 dark:text-gray-300">{{ $homework->homework_url }}</td>
                                          <td class="p-2">
                                              <input type="datetime-local" id="release_date_{{ $homework->homework_id }}" 
                                                  name="release_dates[{{ $homework->homework_id }}]" 
                                                  value="{{ $associatedHomework ? \Carbon\Carbon::parse($associatedHomework->pivot->release_date)->format('Y-m-d\TH:i') : '' }}"
                                                  class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                                  {{ $associatedHomework ? '' : 'disabled' }}>
                                          </td>
                                          <td class="p-2">
                                              <input type="datetime-local" id="due_date_{{ $homework->homework_id }}" 
                                                  name="due_dates[{{ $homework->homework_id }}]" 
                                                  value="{{ $associatedHomework ? \Carbon\Carbon::parse($associatedHomework->pivot->due_date)->format('Y-m-d\TH:i') : '' }}"
                                                  class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white"
                                                  {{ $associatedHomework ? '' : 'disabled' }}>
                                          </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                          </table>
                      </div>
                  </div>
      
                  <div class="flex justify-center mt-6">
                      <button 
                          type="submit" 
                          class="blueButton rounded-xl sm:w-[50%] md:w-[35%] lg:w-[30%] py-3 text-white font-bold text-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                          Atualizar associações de tarefas
                      </button>
                  </div>
              </form>
          </div>
      </div>
      
      <script>
          function toggleDateFields(homeworkId) {
              const checkbox = document.querySelector(`input[name="homeworks[]"][value="${homeworkId}"]`);
              const releaseDateField = document.getElementById(`release_date_${homeworkId}`);
              const dueDateField = document.getElementById(`due_date_${homeworkId}`);
      
              if (checkbox.checked) {
                  releaseDateField.disabled = false;
                  dueDateField.disabled = false;
              } else {
                  releaseDateField.disabled = true;
                  dueDateField.disabled = true;
              }
          }
      </script>
  </body>
</x-layout>
