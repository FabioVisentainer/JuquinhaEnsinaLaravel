<x-layout>
    <body class="body bg-slate-50">
        <nav class="flex justify-between items-center">
        <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
          <div class="max-[770px]:hidden">
            <!-- Div do botao de voltar -->
            <a href="{{ route('teachers.homework.home') }}"><img class="invertColor cursor-pointer pointer-events-auto" src="{{ asset('images/voltar.png') }}" alt="Botao de voltar a pagina" width="40px"></a>
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
            <img class="moon cursor-pointer drop-shadow-[0_0px_16px_rgba(4,15,140)]" src="{{ asset('images/lua.png') }}"" alt="" width="40px">
            <img class="sun cursor-pointer dark:drop-shadow-[0_0px_30px_rgba(255,232,150)] hidden" src="{{ asset('images/sol.png') }}" alt="" width="40px">
          </div>
      
          <div>
            <img src="{{ asset('images/skillos.png') }}" alt="Company image" width="40px">
          </div>
        </div>
        </nav>

        <div class="total relative top-1 transition-all duration-300 ease-in-out">
            <h1 class="pageTitle text-4xl md:text-6xl mt-4">Liberação de Tarefas - {{ $class->class_name }} - {{ $class->class_year }}</h1>
        
            @if(session('success'))
                <div class="alert alert-success mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif
        
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
                @if($homeworks->isEmpty())
                    <h1 class="pageTitle text-2xl md:text-3xl">Não há Registros de Tarefas para esta turma.</h1>
                @else
                    <form action="{{ route('teachers.homework.update', ['class_id' => $class->class_id]) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
        
                        <div id="homeworkList" class="grid gap-4 p-4 bg-gray-200 rounded-lg w-full dark:bg-gray-800 mt-6">
                            <div class="homework bg-white p-4 rounded-lg shadow flex flex-col dark:bg-gray-700 overflow-x-auto">
                                <table class="w-full">
                                    <thead>
                                        <tr class="border-b-2 border-gray-300 dark:border-gray-600">
                                            <th class="text-left p-2 text-gray-800 dark:text-white">Tarefa</th>
                                            <th class="text-left p-2 text-gray-800 dark:text-white">Descrição</th>
                                            <th class="text-left p-2 text-gray-800 dark:text-white">Data de Entrega</th>
                                            <th class="text-left p-2 text-gray-800 dark:text-white">Data de Liberação</th>
                                            <th class="text-left p-2 text-gray-800 dark:text-white">Liberar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($homeworks as $homework)
                                            <tr class="border-b border-gray-300 dark:border-gray-600">
                                                <td class="p-2 text-gray-700 dark:text-gray-300">{{ $homework->homework_name }}</td>
                                                <td class="p-2">
                                                    <input type="text" 
                                                        name="homework[{{ $homework->homework_id }}][description]" 
                                                        value="{{ old('homework.' . $homework->homework_id . '.description', $relatedHomeworks[$homework->homework_id]->description ?? '') }}" 
                                                        class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white" 
                                                        {{ isset($relatedHomeworks[$homework->homework_id]) && $relatedHomeworks[$homework->homework_id]->is_active ? 'required' : '' }}>
                                                </td>
                                                <td class="p-2">
                                                    <input type="datetime-local" 
                                                        name="homework[{{ $homework->homework_id }}][due_date]" 
                                                        value="{{ old('homework.' . $homework->homework_id . '.due_date', $relatedHomeworks[$homework->homework_id]->due_date ?? '') }}" 
                                                        class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white" 
                                                        {{ isset($relatedHomeworks[$homework->homework_id]) && $relatedHomeworks[$homework->homework_id]->is_active ? 'required' : '' }}>
                                                </td>
                                                <td class="p-2">
                                                    <input type="datetime-local" 
                                                        name="homework[{{ $homework->homework_id }}][release_date]" 
                                                        value="{{ old('homework.' . $homework->homework_id . '.release_date', $relatedHomeworks[$homework->homework_id]->release_date ?? '') }}" 
                                                        class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white" 
                                                        {{ isset($relatedHomeworks[$homework->homework_id]) && $relatedHomeworks[$homework->homework_id]->is_active ? 'required' : '' }}>
                                                </td>
                                                <td class="p-2 text-center">
                                                    <input type="hidden" name="homework[{{ $homework->homework_id }}][is_active]" value="0">
                                                    <input type="checkbox" 
                                                        name="homework[{{ $homework->homework_id }}][is_active]" 
                                                        value="1"
                                                        class="form-checkbox h-5 w-5 text-blue-600 dark:bg-gray-800 dark:border-gray-600 focus:ring-blue-500"
                                                        {{ isset($relatedHomeworks[$homework->homework_id]) && $relatedHomeworks[$homework->homework_id]->is_active ? 'checked' : '' }}>
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
                                Salvar Alterações
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
        <h1 class="pageTitle text-4xl md:text-6xl mt-10">Alunos com Tarefas Incompletas</h1>

        <div class="container mx-auto p-4 py-8">
            <div class="col-span-4 flex items-center gap-2">
                <input 
                    id="searchInput" 
                    type="text" 
                    placeholder="Pesquisar..." 
                    class="flex-grow p-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white mb-3" 
                />
                <a href="#">
                    <button 
                        class="w-16 font-bold h-full flex items-center justify-center bg-blue-500 text-white rounded-r-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 py-3 mb-3">
                        <i class="fas fa-filter py-1.8"></i>
                    </button>
                </a>
            </div> 
        
            <div class="container mx-auto p-4 py-8">
                @if($studentsWithIncompleteHomeworks->isEmpty())
                    <p class="text-2xl md:text-3xl">Nenhum aluno tem tarefas incompletas para esta turma.</p>
                @else
                    <table class="w-full mt-6 bg-gray-200 rounded-lg shadow dark:bg-gray-800">
                        <thead>
                            <tr class="border-b-2 border-gray-300 dark:border-gray-600">
                                <th class="p-2 text-left text-gray-800 dark:text-white">Nome do Aluno</th>
                                <th class="p-2 text-left text-gray-800 dark:text-white">Nome da Tarefa</th>
                                <th class="p-2 text-left text-gray-800 dark:text-white">Data de Entrega</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($studentsWithIncompleteHomeworks as $student)
                                <tr class="border-b border-gray-300 dark:border-gray-600">
                                    <td class="p-2 text-gray-700 dark:text-gray-300">{{ $student->student_name }}</td>
                                    <td class="p-2 text-gray-700 dark:text-gray-300">{{ $student->homework_name }}</td>
                                    <td class="p-2 text-gray-700 dark:text-gray-300">{{ \Carbon\Carbon::parse($student->due_date)->format('Y-m-d H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
    </div>
    
    {{-- <a href="{{ route('teachers.homework.home') }}">Voltar</a><br><br>
    <h1>Liberação de Tarefas - {{ $class->class_name }} - {{ $class->class_year }}</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <br>

    @if($homeworks->isEmpty())
        <p>Não há Registros de Tarefas para esta turma.</p>
    @else
        <form action="{{ route('teachers.homework.update', ['class_id' => $class->class_id]) }}" method="POST">
            @csrf
            @method('PUT')

            <table>
                <thead>
                    <tr>
                        <th>Tarefa</th>
                        <th>Descrição</th>
                        <th>Data de Entrega</th>
                        <th>Data de Liberação</th>
                        <th>Liberar</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($homeworks as $homework)
                        <tr>
                            <td>{{ $homework->homework_name }}</td>
                            <td>
                                <input type="text" name="homework[{{ $homework->homework_id }}][description]" 
                                    value="{{ old('homework.' . $homework->homework_id . '.description', $relatedHomeworks[$homework->homework_id]->description ?? '') }}" 
                                    {{ isset($relatedHomeworks[$homework->homework_id]) && $relatedHomeworks[$homework->homework_id]->is_active ? 'required' : '' }}>
                            </td>
                            <td>
                                <input type="datetime-local" name="homework[{{ $homework->homework_id }}][due_date]" 
                                    value="{{ old('homework.' . $homework->homework_id . '.due_date', $relatedHomeworks[$homework->homework_id]->due_date ?? '') }}" 
                                    {{ isset($relatedHomeworks[$homework->homework_id]) && $relatedHomeworks[$homework->homework_id]->is_active ? 'required' : '' }}>
                            </td>
                            <td>
                                <input type="datetime-local" name="homework[{{ $homework->homework_id }}][release_date]" 
                                    value="{{ old('homework.' . $homework->homework_id . '.release_date', $relatedHomeworks[$homework->homework_id]->release_date ?? '') }}" 
                                    {{ isset($relatedHomeworks[$homework->homework_id]) && $relatedHomeworks[$homework->homework_id]->is_active ? 'required' : '' }}>
                            </td>
                            <td>
                                <input type="hidden" name="homework[{{ $homework->homework_id }}][is_active]" value="0">
                                <input type="checkbox" name="homework[{{ $homework->homework_id }}][is_active]" value="1"
                                       {{ isset($relatedHomeworks[$homework->homework_id]) && $relatedHomeworks[$homework->homework_id]->is_active ? 'checked' : '' }}>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="submit">Salvar Alterações</button>
          
        </form>
    @endif

    <h1>Students with Incomplete Homework</h1>

    @if($studentsWithIncompleteHomeworks->isEmpty())
        <p>No students have incomplete homework for this class.</p>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Homework Name</th>
                    <th>Due Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($studentsWithIncompleteHomeworks as $student)
                    <tr>
                        <td>{{ $student->student_name }}</td>
                        <td>{{ $student->homework_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($student->due_date)->format('Y-m-d H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif --}}

</x-layout>