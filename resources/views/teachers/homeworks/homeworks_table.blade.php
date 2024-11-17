<x-layout>
    <body class="body bg-slate-50">
        <nav class="flex justify-between items-center">
            <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
                <div class="max-[770px]:hidden">
                    <!-- Div do botão de voltar -->
                    <a href="{{ route('teachers.homework.home') }}">
                        <img class="invertColor cursor-pointer pointer-events-auto" src="{{ asset('images/voltar.png') }}" alt="Botão de voltar à página" width="40px">
                    </a>
                </div>
            </div>
        
            <!-- Div esquerda da nav -->
            <div>
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
                    <img src="{{ asset('images/skillos.png') }}" alt="Imagem da empresa" width="40px">
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

                        <div class="flex justify-center mt-4">
                            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 transition-colors">Atualizar Tarefas</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </body>
</x-layout>
