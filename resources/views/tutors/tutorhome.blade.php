<x-layout>
    <body class="body bg-slate-50">
        <nav class="flex justify-between items-center">
            <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
                <div class="max-[770px]:hidden">
                    <!-- Div do botao de voltar -->
                    <a href="{{ route('Mainhome') }}">
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

        <!-- Conteúdo principal -->
        <main>
            <div class="total relative top-1 transition-all duration-300 ease-in-out">
                <div>
                    <h1 class="pageTitle">Olá Tutor!</h1>
                </div>

                <!-- Formulário de seleção de aluno -->
                <div class="w-full max-w-md mx-auto mt-5 px-4 sm:px-0">
                    <div class="relative">
                        <form method="POST" id="studentForm">
                            @csrf
                            <select id="students" name="student_user_id" onchange="submitForm()" class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-2 px-3 sm:py-3 sm:px-4 pr-8 rounded-lg leading-tight focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-600 dark:text-white">
                                <option disabled selected>Escolha um aluno...</option>
                                @foreach ($students as $student)
                                <option value="{{ $student->student_user_id }}" {{ $student->student_user_id == $studentUserId ? 'selected' : '' }}>
                                    {{ $student->student_name }}
                                </option>
                                @endforeach
                            </select>
                        </form>
                        <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                            <svg class="fill-current h-4 w-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M5.2 7.5l4.3 4.3 4.3-4.3a.7.7 0 111 1l-5 5a.7.7 0 01-1 0l-5-5a.7.7 0 111-1z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Cards com links -->
                <div class="dadCards">
                    <div class="card bg-[#FFEEB1] drop-shadow-2xl dark:drop-shadow-[0_0px_30px_rgba(255,232,150,0.5)]">
                        <a href="{{ route('tutors.homework.table', [$studentUserId]) }}">
                            <img class="p-8" src="{{ asset('images/atividades.png') }}" alt="Atividades" width="350px">
                            <p class="text-3xl p-2 sm:text-4xl drop-shadow-lg">Ver Atividades</p>
                        </a>
                    </div>
                    <div class="card bg-[#C5B9EF] drop-shadow-2xl dark:drop-shadow-[0_0px_30px_rgba(148,119,252,0.5)]">
                        <a href="{{ route('tutors.activity.table', [$studentUserId]) }}">
                            <img class="p-8" src="{{ asset('images/tarefas.png') }}" alt="Tarefas" width="350px">
                            <p class="text-3xl p-2 sm:text-4xl drop-shadow-lg">Ver Tarefas</p>
                        </a>
                    </div>
                    <div class="card bg-[#BEF1EE] drop-shadow-2xl dark:drop-shadow-[0_0px_30px_rgba(176,255,250,0.5)]">
                        <a href="{{ route('tutors.reports.home', [$studentUserId]) }}">
                            <img class="p-8" src="{{ asset('images/frequencia.png') }}" alt="Videos" width="350px">
                            <p class="text-3xl p-2 sm:text-4xl drop-shadow-lg">Desempenho do Aluno</p>
                        </a>
                    </div>
                    <div class="card bg-[#B9CAEF] drop-shadow-2xl dark:drop-shadow-[0_0px_30px_rgba(0, 102, 204, 0.5)]">
                        <a href="{{ route('tutors.videos.home', [$studentUserId]) }}">
                            <img class="p-8" src="{{ asset('images/videos(blue).png') }}" alt="Tarefas" width="350px">
                            <p class="text-3xl p-2 sm:text-4xl drop-shadow-lg">Ver videos</p>
                        </a>
                    </div>
                    <div class="card bg-[#FFB1B2] drop-shadow-2xl dark:drop-shadow-[0_0px_30px_rgba(255, 0, 0)]">
                        <a href="{{ route('tutors.grades.table', [$studentUserId]) }}">
                            <img class="p-8" src="{{ asset('images/boletim.png') }}" alt="Videos" width="350px">
                            <p class="text-3xl p-2 sm:text-4xl drop-shadow-lg">Consultar Boletim</p>
                        </a>
                    </div>

                </div>
            </div>
        </main>
        
        <script>
            function submitForm() {
                const studentId = document.getElementById('students').value;
                const form = document.getElementById('studentForm');
                form.action = `{{ route('tutors.home.student', '') }}/${studentId}`;
                form.submit();
            };
            var unreadCount = @json($unreadCount);
            function temNotificacoes() {
                const notificationIcon = document.getElementById('notificationIcon');
                    if (unreadCount >= 1) {
                    notificationIcon.src = "{{ asset('images/UnreadNotifications.png') }}"; 
                    } else {
                    notificationIcon.src = "{{ asset('images/notificacao.png') }}";
                }
            };
            temNotificacoes();
        </script>
    </body>
</x-layout>
