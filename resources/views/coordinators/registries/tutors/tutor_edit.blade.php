<x-layout>
    <body class="body bg-slate-50">
        <nav class="flex justify-between items-center">
        <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
          <div class="max-[770px]:hidden">
            <!-- Div do botao de voltar -->
            <a href="{{ route('coordinators.registries.tutors.home') }}"><img class="invertColor cursor-pointer pointer-events-auto" src="{{ asset('images/voltar.png') }}" alt="Botao de voltar a pagina" width="40px"></a>
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
    <main>

    
        <div class="total relative top-1 transition-all duration-300 ease-in-out">
            <div>
                <h1 class="pageTitle text-4xl md:text-6xl">Editar tutor</h1>
              </div>
                <div class="contCenter">
                <img src="{{ asset('images/perfil.png') }}" alt="Imagem do Perfil" width="250px" class="invertColor">
                <form action="{{ route('coordinators.registries.tutors.update', $tutor->tutor_id) }}" method="POST" class="form">
                @csrf
                @method('PUT')

                <x-registries.tutor_form 
                    :tutor="$tutor" 
                    :cities="$cities"  
                />
                <input type="submit" value="Atualizar tutor" class="blueButton rounded-full sm:w-[90%] md:w-[75%] lg:w-[70%]">
                </form>
            </div>

        </div>

    <h2 class="pageTitle text-4xl md:text-6xl">Alunos associados</h2>
        <div>
            <div class="flex flex-col items-center justify-center">
                <a href="{{ route('coordinators.registries.tutors.selectStudents', $tutor->tutor_id) }}" class="border border-gray-300 text-gray-700 bg-white hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-offset-2 rounded-lg px-4 py-2 transition duration-150 ease-in-out">
                    Select Students
                </a>
                </div>
        
                <div class="grid gap-4 p-4 bg-gray-200 rounded-lg w-full dark:bg-gray-800 md:w-3/4 lg:w-1/2 mx-auto">
                    @if($associatedStudents->isEmpty())
                        <p class="text-gray-600 dark:text-gray-300">No students associated with this tutor.</p>
                    @else
                        @foreach($associatedStudents as $associatedStudent)
                            <div class="bg-white p-4 rounded-lg shadow flex justify-between items-center dark:bg-gray-700 w-full">
                                <div class="flex flex-col mr-4">
                                    <h3 class="text-2xl font-semibold dark:text-white">{{ $associatedStudent->student->student_name }}</h3>
                                    <p class="mt-1 ml-0.5 text-gray-600 text-lg dark:text-gray-300"><span class="font-bold">Gender:</span> {{ $associatedStudent->student->student_gender }}</p>
                                    <p class="text-gray-600 dark:text-gray-300"><span class="font-bold ml-0.5">Registry Date:</span> {{ $associatedStudent->student->student_registry_date }}</p>
                                </div>
                                <form action="{{ route('coordinators.registries.tutors.deleteStudents', [$tutor->tutor_id, $associatedStudent->student_user_id]) }}" method="POST" class="flex-shrink-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white rounded-xl px-4 py-2 hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">
                                        Remove
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    @endif
                </div>
        </div>
        {{-- <a href="{{ route('coordinators.registries.tutors.selectStudents', $tutor->tutor_id) }}">Select Students</a> --}}

        <br><br>

        {{-- @if($associatedStudents->isEmpty())
            <p>No students associated with this tutor.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Gender</th>
                        <th>Registry Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($associatedStudents as $associatedStudent)
                        <tr>
                            <td>{{ $associatedStudent->student->student_name }}</td>
                            <td>{{ $associatedStudent->student->student_gender }}</td>
                            <td>{{ $associatedStudent->student->student_registry_date }}</td>
                            <td>
                                <form action="{{ route('coordinators.registries.tutors.deleteStudents', [$tutor->tutor_id, $associatedStudent->student_user_id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif --}}
    </main>
    <x-errors />
</x-layout>