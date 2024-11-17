<x-layout>
    <body class="body bg-slate-50">
        <nav class="flex justify-between items-center">
            <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
                <div class="max-[770px]:hidden">
                    <!-- Div do botão de voltar -->
                    <a href="{{ route('teachers.grades.home') }}">
                        <img class="invertColor cursor-pointer pointer-events-auto" src="{{ asset('images/voltar.png') }}" alt="Botão de voltar à página" width="40px">
                    </a>
                </div>
            </div>

            <!-- Div esquerda da nav -->
            <div class="">
                <ul class="navText opacity-0 top-[120px] gap-4 sm:pointer-events-auto pointer-events-none">
                    <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
                        <a href="{{ route('teachers.home') }}">
                            <p class="navTitle">Início</p>
                        </a>
                    </li>
                    <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
                        <a href="{{ route('teachers.activity.home') }}">
                            <p class="navTitle">Liberar Atividades</p>
                        </a>
                    </li>
                    <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
                        <a href="{{ route('teachers.homework.home') }}">
                            <p class="navTitle">Liberar Tarefas</p>
                        </a>
                    </li>
                    <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
                        <a href="{{ route('teachers.frequency.home') }}">
                            <p class="navTitle">Registrar Frequência</p>
                        </a>
                    </li>
                    <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
                        <a href="{{ route('teachers.grades.home') }}">
                            <p class="navTitle">Registrar Boletim</p>
                        </a>
                    </li>
                    <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
                        <a href="{{ route('teachers.videos.home') }}">
                            <p class="navTitle">Enviar Vídeos</p>
                        </a>
                    </li>
                </ul>
            </div>
            <div>
                <img class="hamburger invertColor cursor-pointer transition-all ease-out duration-500 md:hidden block max-[800px]:ml-3" src="{{ asset('images/hamburger.png') }}" alt="Hamburger" width="45px">
                <img class="x invertColor cursor-pointer hidden transition-all ease-linear duration-500 md:hidden max-[800px]:ml-3" src="{{ asset('images/x.png') }}" alt="Fechar hambúrguer" width="30px">
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

        <main>
            <div class="total relative top-1 transition-all duration-300 ease-in-out">
                <div>
                    <h1 class="pageTitle text-4xl md:text-6xl mt-4 text-gray-800 dark:text-white">Boletim dos Alunos - {{ $class->class_name }} - {{ $class->class_year }}</h1>
                </div>

                @if(session('success'))
                    <div class="alert alert-success mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded mx-auto max-w-lg">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="container mx-auto p-4 py-8">
                    @if($students->isEmpty())
                        <div class="bg-yellow-100 p-4 rounded-lg shadow-md dark:bg-yellow-500 dark:text-gray-800">
                            <p class="text-xl font-semibold text-center">Não há Estudantes Nesta Turma.</p>
                        </div>
                    @else
                        <div class="bg-white p-4 rounded-lg shadow dark:bg-gray-700">
                            <table class="w-full">
                                <thead class="bg-gradient-to-r from-blue-500 to-blue-400 text-white border-b-2 border-gray-300 dark:border-gray-600">
                                    <tr>
                                        <th class="p-2">Nome do Aluno</th>
                                        <th class="p-2">Ações</th>
                                        @foreach($evaluations->unique('evaluation_number') as $evaluation)
                                            <th class="p-2">Boletim {{ $evaluation->evaluation_number }}</th>
                                            <th class="p-2">Última Atualização</th>
                                            <th class="p-2">Ações</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $student)
                                        <tr class="border-b border-gray-300 dark:border-gray-600">
                                            <td class="p-2 text-gray-700 dark:text-gray-300 text-center">{{ $student->student_name }}</td>
                                            <td class="p-2 text-center">
                                                <a href="{{ route('teachers.grades.create', ['student_user_id' => $student->student_user_id, 'class_id' => $class->class_id]) }}" class="text-blue-500 hover:text-blue-700">Novo Boletim</a>
                                            </td>
                                            @foreach($evaluations->where('student_user_id', $student->student_user_id) as $evaluation)
                                                <td class="p-2 text-gray-700 dark:text-gray-300 text-center">{{ $evaluation->evaluation_number }}</td>
                                                <td class="p-2 text-gray-700 dark:text-gray-300 text-center">{{ $evaluation->updated_at }}</td>
                                                <td class="p-2 text-gray-700 dark:text-gray-300 text-center">
                                                    <a href="{{ route('teachers.grades.edit', ['student_user_id' => $student->student_user_id, 'evaluation_id' => $evaluation->evaluation_id, 'class_id' => $class->class_id]) }}" class="text-blue-500 hover:text-blue-700">Editar</a>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </body>
</x-layout>
