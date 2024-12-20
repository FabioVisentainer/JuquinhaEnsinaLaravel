<x-layout>
    <body class="body bg-slate-50">
      <nav class="flex justify-between items-center">
        <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
          <div class="max-[770px]:hidden">
            <!-- Div do botão de voltar -->
            <a href="{{ route('teachers.frequency.home') }}">
              <img class="invertColor cursor-pointer pointer-events-auto" src="{{ asset('images/voltar.png') }}" alt="Botão de voltar à página" width="40px">
            </a>
          </div>
        </div>
        
        <!-- Div esquerda da nav -->
        <div class="">
          <ul class="navText opacity-0 top-[120px] gap-4 sm:pointer-events-auto pointer-events-none">
            <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
              <a href="{{ route('teachers.home') }}"><p class="navTitle">Início</p></a>
            </li>
            <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
              <a href="{{ route('teachers.activity.home') }}"><p class="navTitle">Liberar Atividades</p></a>
            </li>
            <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
              <a href="{{ route('teachers.homework.home') }}"><p class="navTitle">Liberar Tarefas</p></a>
            </li>
            <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
              <a href="{{ route('teachers.frequency.home') }}"><p class="navTitle">Registrar Frequência</p></a>
            </li>
            <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
              <a href="{{ route('teachers.grades.home') }}"><p class="navTitle">Registrar Boletim</p></a>
            </li>
            <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
              <a href="{{ route('teachers.videos.home') }}"><p class="navTitle">Enviar Vídeos</p></a>
            </li>
          </ul>
        </div>
  
        <div>
          <img class="hamburger invertColor cursor-pointer transition-all ease-out duration-500 md:hidden block max-[800px]:ml-3" src="{{ asset('images/hamburger.png') }}" alt="Hamburguer" width="45px">
          <img class="x invertColor cursor-pointer hidden transition-all ease-linear duration-500 md:hidden max-[800px]:ml-3" src="{{ asset('images/x.png') }}" alt="Fechar hamburguer" width="30px">
        </div>
        
        <div class="flex gap-8 p-5">
          <!-- Div direita da nav -->
          <div>
            <img class="moon cursor-pointer drop-shadow-[0_0px_16px_rgba(4,15,140)]" src="{{ asset('images/lua.png') }}" alt="" width="40px">
            <img class="sun cursor-pointer dark:drop-shadow-[0_0px_30px_rgba(255,232,150)] hidden" src="{{ asset('images/sol.png') }}" alt="" width="40px">
          </div>
          
          <div>
            <img src="{{ asset('images/skillos.png') }}" alt="Imagem da empresa" width="40px">
          </div>
        </div>
      </nav>
  
      <div class="total relative top-1 transition-all duration-300 ease-in-out">
        <h1 class="pageTitle text-4xl md:text-6xl mb-4">Registros de Frequência - {{ $class->class_name }} - {{ $class->class_year }} </h1>
        
        @if(session('success'))
          <div class="alert alert-success mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            {{ session('success') }}
          </div>
        @endif
  
        <!-- Formulário de Seleção de Data -->
        <form id="frequencyForm" onsubmit="event.preventDefault(); submitFrequencyForm();" class="flex flex-col items-center gap-4 mt-6">
          <label for="date" class="text-gray-700 font-semibold dark:text-gray-300">Data da Frequência:</label>
          <input 
            type="date" 
            id="date" 
            name="date" 
            value="{{ date('Y-m-d') }}" 
            required 
            class="p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white"
          >
          <button type="submit" class="blueButton rounded-lg px-4 py-2 text-white font-bold hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">Realizar Chamada</button>
        </form>
  
        <br>
  
        <div class="total relative top-1 transition-all duration-300 ease-in-out">
          <div class="container mx-auto p-4 py-8">
            @if($frequencytable->isEmpty())
              <div class="bg-yellow-100 p-4 rounded-lg shadow-md dark:bg-yellow-500 dark:text-gray-800">
                <p class="text-xl font-semibold text-center">Não há Registros de Frequência para esta turma.</p>
              </div>
            @else
              <div class="bg-white p-6 rounded-lg shadow-lg drop-shadow-xl dark:bg-gray-700 dark:drop-shadow-[0_0px_30px_rgba(0, 102, 204, 0.3)] mb-8">
                <h2 class="text-3xl font-semibold text-center text-gray-800 dark:text-white">Frequência</h2>
                
                <!-- Tabela com rolagem horizontal para telas pequenas -->
                <div class="overflow-x-auto">
                  <table class="min-w-full mt-4 table-auto">
                    <thead class="bg-gradient-to-r from-blue-500 to-blue-400 text-white border-b-2 border-gray-300">
                      <tr>
                        <th class="p-2 text-left">Data de Frequência</th>
                        <th class="p-2">Ações</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($frequencytable as $frequency)
                        <tr class="border-b border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800">
                          <td class="p-2 text-gray-700 dark:text-gray-300">{{ $frequency->frequency_date }}</td>
                          <td class="p-2 text-center">
                            <a href="{{ route('teachers.frequency.edit', ['class_id' => $class->class_id, 'frequency_table_id' => $frequency->frequency_table_id]) }}" 
                               class="text-blue-500 hover:text-blue-700 font-semibold">
                               Editar
                            </a>
                          </td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            @endif
          </div>
        </div>
  
        <!-- JavaScript para manipular o envio do formulário -->
        <script>
          function submitFrequencyForm() {
            const date = document.getElementById('date').value;
            const classId = "{{ $class->class_id }}"; 
            const url = `{{ route('teachers.frequency.create', ['class_id' => '__class_id__', 'date' => '__date__']) }}`
              .replace('__class_id__', classId)
              .replace('__date__', date);
            window.location.href = url;
          }
        </script>
      </div>
    </body>
  </x-layout>
  