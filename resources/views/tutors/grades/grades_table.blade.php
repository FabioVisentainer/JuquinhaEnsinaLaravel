<x-layout>
    <body class="body bg-slate-50">
        <nav class="flex justify-between items-center">
            <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
                <div class="max-[770px]:hidden">
                    <!-- Div do botao de voltar -->
                    <a href="{{ route('tutors.home.student.get', [$studentUserId]) }}">
                        <img class="invertColor cursor-pointer pointer-events-auto" src="{{ asset('images/voltar.png') }}" alt="Botao de voltar a pagina" width="40px">
                    </a>
                </div>
            </div>

            <!-- Div esquerda da nav -->
            <div>
                <ul class="navText opacity-0 top-[120px] gap-4 sm:pointer-events-auto pointer-events-none">
                    <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
                        <a href="{{ route('tutors.home') }}">
                            <p class="navTitle">Inicio</p>
                        </a>
                    </li>
                    <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
                        <a href="{{ route('tutors.homework.table', [$studentUserId]) }}">
                            <p class="navTitle">Atividades</p>
                        </a>
                    </li>
                    <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
                        <a href="{{ route('tutors.activity.table', [$studentUserId]) }}">
                            <p class="navTitle">Tarefas</p>
                        </a>
                    </li>
                    <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
                        <a href="{{ route('tutors.reports.home', [$studentUserId]) }}">
                            <p class="navTitle">Desempenho</p>
                        </a>
                    </li>
                    <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
                        <a href="{{ route('tutors.videos.home', [$studentUserId]) }}">
                            <p class="navTitle">Vídeos</p>
                        </a>
                    </li>
                    <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
                        <a href="{{ route('tutors.grades.table', [$studentUserId]) }}">
                            <p class="navTitle">Boletim</p>
                        </a>
                    </li>
                </ul>
            </div>
            
            <div>
                <img class="hamburger invertColor cursor-pointer transition-all ease-out duration-500 md:hidden block max-[800px]:ml-3" src="{{ asset('images/hamburger.png') }}" alt="Hamburger" width="45px">
                <img class="x invertColor cursor-pointer hidden transition-all ease-linear duration-500 md:hidden max-[800px]:ml-3" src="{{ asset('images/x.png') }}" alt="Exit hamburguer" width="30px">
            </div>

            <!-- Icones de navegação à direita -->
            <div class="flex gap-8 p-5">
                <div>
                    <img class="moon cursor-pointer drop-shadow-[0_0px_16px_rgba(4,15,140)]" src="{{ asset('images/lua.png') }}" alt="Botão Lua" width="40px">
                    <img class="sun cursor-pointer dark:drop-shadow-[0_0px_30px_rgba(255,232,150)] hidden" src="{{ asset('images/sol.png') }}" alt="Botão Sol" width="40px">
                </div>
                <div>
                    <a href="{{ route('tutors.notifications.home', [$studentUserId]) }}">
                        <img id="notificationIcon" class="invertColor cursor-pointer" src="{{ asset('images/notificacao.png') }}" alt="Botao de notificacoes" width="40px">
                    </a>
                </div>
                <div>
                    <img src="{{ asset('images/skillos.png') }}" alt="Company image" width="40px">
                </div>
            </div>
        </nav>
    {{-- <a href="{{ route('tutors.home.student.get', [$studentUserId]) }}">Voltar</a><br><br>
    <h1>Boletim - {{ $student->student_name }}</h1>

    <p>Student user ID: {{ $studentUserId }}</p>
    <p>Student Name: {{ $student->student_name }}</p> --}}

    <main>
        <div class="total relative top-1 transition-all duration-300 ease-in-out">
            <div>
                <h1 class="pageTitle text-gray-800 dark:text-white">Boletim de Notas</h1>
            </div>
    
            <div class="container mx-auto p-4 py-8">
                
                <!-- Concept Table -->
                <div class="bg-white p-6 rounded-lg shadow-lg drop-shadow-xl dark:bg-gray-700 dark:drop-shadow-[0_0px_30px_rgba(0, 102, 204, 0.3)] mb-8">
                    <h2 class="text-3xl font-semibold text-center text-gray-800 dark:text-white">Conceitos</h2>
                    
                    <!-- Tabela com rolagem horizontal para telas pequenas -->
                    <div class="overflow-x-auto">
                        <table class="min-w-full mt-4 table-auto">
                            <thead class="bg-gradient-to-r from-blue-500 to-blue-400 text-white border-b-2 border-gray-300">
                                <tr>
                                    <th class="p-2">Nome do Conceito</th>
                                    <th class="p-2">Abreviação</th>
                                    <th class="p-2">Descrição</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($concepts as $concept)
                                    <tr class="border-b border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800">
                                        <td class="p-2 text-gray-800 dark:text-gray-300">{{ $concept->concept_name }}</td>
                                        <td class="p-2 text-gray-800 dark:text-gray-300 text-center">{{ $concept->concept_abbreviation }}</td>
                                        <td class="p-2 text-gray-800 dark:text-gray-300">{{ $concept->concept_description }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
    
                <!-- Grade Report -->
                @foreach ($gradeReport as $class => $subjects)
                    <div class="bg-white p-6 rounded-lg shadow-lg drop-shadow-xl dark:bg-gray-700 dark:drop-shadow-[0_0px_30px_rgba(0, 102, 204, 0.3)] mb-8">
                        <h2 class="text-3xl font-semibold text-center text-gray-800 dark:text-white">{{ explode(' - ', $class)[0] }} - {{ explode(' - ', $class)[1] }}</h2>
                        
                        <!-- Tabela com rolagem horizontal para telas pequenas -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full mt-4 table-auto">
                                <thead class="bg-gradient-to-r from-blue-500 to-blue-400 text-white border-b-2 border-gray-300">
                                    <tr>
                                        <th class="p-2">Disciplina</th>
                                        <th class="p-2">Assunto</th>
                                        @php
                                            $maxEvaluations = 0;
                                            foreach ($subjects as $subject) {
                                                $maxEvaluations = max($maxEvaluations, count($subject['evaluations']));
                                            }
                                        @endphp
                                        @for ($i = 1; $i <= $maxEvaluations; $i++)
                                            <th class="p-2">{{ $i }}° Nota</th>
                                        @endfor
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($subjects as $subject => $data)
                                        <tr class="border-b border-gray-300 dark:border-gray-600 bg-gray-50 dark:bg-gray-800">
                                            <td class="p-2 text-gray-800 dark:text-gray-300">{{ explode(' - ', $subject)[0] }}</td>
                                            <td class="p-2 text-gray-800 dark:text-gray-300">{{ explode(' - ', $subject)[1] }}</td>
                                            @for ($i = 1; $i <= $maxEvaluations; $i++)
                                                <td class="p-2 text-gray-800 dark:text-gray-300 text-center">{{ $data['evaluations'][$i] ?? 'N/A' }}</td>
                                            @endfor
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
    
                <!-- No Grades Message -->
                @if (empty($gradeReport))
                    <div class="bg-yellow-100 p-4 rounded-lg shadow-md dark:bg-yellow-500 dark:text-gray-800">
                        <p class="text-xl font-semibold text-center">No grades available for this student.</p>
                    </div>
                @endif
            </div>
        </div>
    </main>
    
    
    
    
</x-layout>