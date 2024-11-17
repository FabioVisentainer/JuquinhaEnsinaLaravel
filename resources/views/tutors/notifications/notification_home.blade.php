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
        <div class="total relative top-1 transition-all duration-300 ease-in-out">
            <h1 class="pageTitle text-4xl md:text-6xl">Minhas Notificações</h1>
        
            @if($notifications->isEmpty())
                <h1 class="pageTitle text-2xl md:text-3xl">Você não tem notificações.</h1>
            @else
                <div class="container mx-auto p-4 py-8">
                    <div id="notificationList" class="grid gap-4 p-4 bg-gray-200 rounded-lg w-full dark:bg-gray-800 mt-6">
                        @foreach($notifications as $notification)
                        <div class="notification bg-white p-4 rounded-lg shadow flex justify-between items-center dark:bg-gray-700">
                            <div class="flex flex-col">
                                <h3 class="text-2xl font-semibold dark:text-white">Professor: {{ $notification->teacher_name ?? 'NI' }}</h3>
                                <p class="mt-1 text-gray-600 text-xl dark:text-gray-300"><span class="font-bold">Título:</span> {{ $notification->notification_title }}</p>
                                <p class="mt-1 text-gray-600 dark:text-gray-300"><span class="font-bold">Mensagem:</span> {{ $notification->notifications_message }}</p>
                                <p class="mt-1 text-gray-600 text-sm dark:text-gray-300"><span class="font-bold">Criado em:</span> {{ \Carbon\Carbon::parse($notification->created_at)->format('Y-m-d H:i') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
        
                    <!-- Pagination -->
                    <div class="flex justify-center mt-6">
                        <div class="pagination bg-gray-100 rounded-lg p-2 dark:bg-gray-700">
                            {{ $notifications->links('pagination::tailwind') }}
                        </div>
                    </div>
                </div>
            @endif
        </div>
        
</x-layout>