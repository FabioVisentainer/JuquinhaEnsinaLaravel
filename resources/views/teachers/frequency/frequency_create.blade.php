<x-layout>
<body class="body bg-slate-50">
        <nav class="flex justify-between items-center">
        <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
          <div class="max-[770px]:hidden">
            <!-- Div do botao de voltar -->
            <a href="{{ route('teachers.frequency.table', ['class_id' => $class_id]) }}"><img class="invertColor cursor-pointer pointer-events-auto" src="{{ asset('images/voltar.png') }}" alt="Botao de voltar a pagina" width="40px"></a>
          </div>
        </div>
      
        
        <!-- Div esquerda da nav -->
      
        <div class="">
          <ul class="navText opacity-0 top-[120px] gap-4 sm:pointer-events-auto pointer-events-none">
          <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
            <a href="{{ route('teachers.home') }}"><p class="navTitle">Inicio</p></a>
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
            <a href="{{ route('teachers.videos.home') }}"><p class="navTitle">Enviar Videos</p></a>
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
            <img src="{{ asset('images/skillos.png') }}" alt="Company image" width="40px">
          </div>
        </div>
        </nav>
        <main>
            <div class="total relative top-1 transition-all duration-300 ease-in-out">
                <div>
                    <h1 class="pageTitle text-4xl md:text-6xl mt-4 text-gray-800 dark:text-white text-center">Registrar Frequência para a Turma - {{ $date }}</h1>
                </div>

                @if(session('success'))
                <div class="alert alert-success mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded mx-auto max-w-lg">
                    {{ session('success') }}
                </div>
                @endif
                
                <div class="container mx-auto p-4 py-8">
                    <form action="{{ route('teachers.frequency.store') }}" method="post" class="space-y-4">
                        @csrf
                        <input type="hidden" name="class_id" value="{{ $class_id }}">
                        <input type="hidden" name="date" value="{{ $date }}">
        
                        <div class="bg-white p-6 rounded-lg shadow-lg drop-shadow-xl dark:bg-gray-700 dark:drop-shadow-[0_0px_30px_rgba(0, 102, 204, 0.3)] mb-8">
                            <table class="min-w-full table-auto">
                                <thead class="bg-gradient-to-r from-blue-500 to-blue-400 text-white border-b-2 border-gray-300">
                                    <tr>
                                        <th class="p-2 text-left">Estudante</th>
                                        <th class="p-2">Presente</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($associatedStudents as $student)
                                        <tr class="border-b border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800">
                                            <td class="p-2 text-gray-700 dark:text-gray-300">{{ $student->student_name }}</td>
                                            <td class="p-2 text-center">
                                                <input type="hidden" name="attendance[{{ $student->student_user_id }}]" value="0">
                                                <input type="checkbox" name="attendance[{{ $student->student_user_id }}]" value="1" checked class="form-checkbox h-5 w-5 text-blue-600 dark:bg-gray-800 dark:border-gray-600 focus:ring-blue-500">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
        
                        <div class="flex justify-center mt-6">
                            <button 
                                type="submit" 
                                class="blueButton rounded-xl sm:w-[50%] md:w-[35%] lg:w-[30%] py-3 text-white font-bold text-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                Salvar Frequência
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>

     
        
        
{{-- <a href="{{ route('teachers.frequency.table', ['class_id' => $class_id]) }}">Voltar</a><br><br>
<h1>Registrar Frequência para a Turma - {{ $date }}</h1>




@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif


<form action="{{ route('teachers.frequency.store') }}" method="post">
        @csrf
        <input type="hidden" name="class_id" value="{{ $class_id }}">
        <input type="hidden" name="date" value="{{ $date }}">
        
        <table>
            <thead>
                <tr>
                    <th>Estudante</th>
                    <th>Presente</th>
                </tr>
            </thead>
            <tbody>
            @foreach($associatedStudents as $student)
                    <tr>
                        <td>{{ $student->student_name }}</td>
                        <td>
                            <!-- Hidden field for "absent" status if not checked -->
                            <input type="hidden" name="attendance[{{ $student->student_user_id }}]" value="0">
                            <!-- Checkbox for "present" status -->
                            <input type="checkbox" name="attendance[{{ $student->student_user_id }}]" value="1" checked>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit">Salvar Frequência</button>
    </form> --}}
</x-layout>