<x-layout>
    <body class="body bg-slate-50">
        <nav class="flex justify-between items-center">
        <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
          <div class="max-[770px]:hidden">
            <!-- Div do botao de voltar -->
            <a href="{{ route('coordinators.registries.students.edit', $student->student_id) }}"><img class="invertColor cursor-pointer pointer-events-auto" src="{{ asset('images/voltar.png') }}" alt="Botao de voltar a pagina" width="40px"></a>
          </div>
        </div>
        
        <!-- Div esquerda da nav -->
      
        <div class="">
          <ul class="navText opacity-0 top-[120px] gap-4 pointer-events-auto sm:pointer-events-none">
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
    <main>
        <div class="total relative top-1 transition-all duration-300 ease-in-out">
            <div>
                <h1 class="pageTitle text-4xl md:text-6xl">Selecione Tutores para o Aluno: {{ $student->student_name }}</h1>
            </div>
    
            <form action="{{ route('coordinators.registries.students.updateTutors', [$student->student_id, $student->student_user_id]) }}" method="POST" class="form">
                @csrf
                <div class="container md:w-3/4 lg:w-1/2 mx-auto p-4 py-8 mt-4">
                    <!-- Linha de pesquisa ocupando toda a largura -->
                    <div class="flex items-center gap-2 mb-4">
                        <!-- Campo de pesquisa ocupando 75% -->
                        <input 
                            type="text" 
                            placeholder="Pesquisar..." 
                            class="flex-grow p-3 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white" 
                        />
    
                        <!-- Botão de enviar -->
                        <button type="submit" class="w-16 font-bold h-full flex items-center justify-center bg-blue-500 text-white rounded-r-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 py-3">
                            ✓
                        </button>
                    </div>
                </div>
    
                <!-- Grid para exibir os tutores -->
                <div class="container md:w-3/4 lg:w-1/2 mx-auto p-4 bg-gray-200 rounded-lg dark:bg-gray-800">
                    <div class="grid gap-4">
                        @foreach($tutors as $tutor)
                            <div class="bg-white p-4 rounded-lg shadow flex items-center justify-between dark:bg-gray-700 w-full">
                                <div class="flex flex-col">
                                    <h3 class="text-2xl font-semibold dark:text-white">{{ $tutor->tutor_name }}</h3>
                                    <p class="text-gray-600 dark:text-gray-300"><span class="font-bold">Data de registro:</span> {{ $tutor->tutor_registry_date }}</p>
                                </div>
    
                                <input type="checkbox" name="tutors[]" value="{{ $tutor->tutor_user_id }}" 
                                    class="ml-4" {{ $associatedTutors->contains('tutor_user_id', $tutor->tutor_user_id) ? 'checked' : '' }}>
                            </div>
                        @endforeach
                    </div>
                </div>
    
                <!-- Botão de submit -->
                <div class="container md:w-3/4 lg:w-1/2 mx-auto mt-4">
                    <button type="submit" class="w-full p-3 bg-blue-500 text-white font-bold rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        Update Tutor Associations
                    </button>
                </div>
            </form>
        </div>
    </main>

    {{-- <form action="{{ route('coordinators.registries.students.updateTutors', [$student->student_id, $student->student_user_id]) }}" method="POST">
        @csrf

        <table>
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Name</th>
                    <th>Registry Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tutors as $tutor)
                    <tr>
                        <td>
                            <input type="checkbox" name="tutors[]" value="{{ $tutor->tutor_user_id }}" 
                                {{ $associatedTutors->contains('tutor_user_id', $tutor->tutor_user_id) ? 'checked' : '' }}>
                        </td>
                        <td>{{ $tutor->tutor_name }}</td>
                        <td>{{ $tutor->tutor_registry_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit">Update Tutor Associations</button>
    </form> --}}

</x-layout>