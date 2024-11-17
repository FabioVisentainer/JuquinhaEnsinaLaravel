<x-layout>
    <body class="body bg-slate-50">
        <nav class="flex justify-between items-center">
            <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
                <div class="max-[770px]:hidden">
                    <!-- Div do botão de voltar -->
                    <a href="{{ route('coordinators.home') }}">
                        <img class="invertColor cursor-pointer pointer-events-auto" src="{{ asset('images/voltar.png') }}" alt="Botão de voltar à página" width="40px">
                    </a>
                </div>
            </div>

            <!-- Div esquerda da nav -->
            <div class="">
                <ul class="navText opacity-0 top-[120px] gap-4 sm:pointer-events-auto pointer-events-none">
                    <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
                        <a href="{{ route('coordinators.home') }}">
                            <p class="navTitle">Início</p>
                        </a>
                    </li>
                    <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
                        <a href="{{ route('coordinators.registries.home') }}">
                            <p class="navTitle">Cadastros</p>
                        </a>
                    </li>
                    <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
                        <a href="{{ route('coordinators.registries.classes.home') }}">
                            <p class="navTitle">Turmas</p>
                        </a>
                    </li>
                    <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
                        <a href="{{ route('coordinators.registries.classessubjects.home') }}">
                            <p class="navTitle">Disciplinas</p>
                        </a>
                    </li>
                    <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
                        <a href="{{ route('coordinators.registries.chronograms.home') }}">
                            <p class="navTitle">Cronogramas</p>
                        </a>
                    </li>
                    <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
                        <a href="{{ route('coordinators.reports.home') }}">
                            <p class="navTitle">Relatórios</p>
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
                    <a href="{{ route('coordinators.notifications.home') }}">
                        <img id="notificationIcon" class="invertColor cursor-pointer" src="{{ asset('images/notificacao.png') }}" alt="Botão de notificações" width="40px">
                    </a>
                </div>

                <div>
                    <img src="{{ asset('images/skillos.png') }}" alt="Imagem da empresa" width="40px">
                </div>
            </div>
        </nav>

        <main>
            <div class="total relative top-1 transition-all duration-300 ease-in-out">
                <h1 class="pageTitle text-4xl md:text-6xl">Notificações</h1>

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <h1 class="pageTitle text-2xl md:text-3xl -mb-8">Notificar Turmas</h1>

                @if($classes->isEmpty())
                    <h1 class="pageTitle text-2xl md:text-3xl">Não há turmas cadastradas.</h1>
                @else
                    <div class="container mx-auto p-4 py-8">
                        <!-- Linha de pesquisa ocupando todas as 4 colunas -->
                        <div class="col-span-4 flex items-center gap-2">
                            <!-- Campo de pesquisa ocupando 75% -->
                            <input id="searchInput" type="text" placeholder="Pesquisar..." class="flex-grow p-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white mb-3" />

                            <!-- Botão com ícone de + ocupando 25% -->
                            <a href="#"><button class="w-16 font-bold h-full flex items-center justify-center bg-blue-500 text-white rounded-r-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 py-3 mb-3">
                                <i class="fas fa-filter py-1.8"></i>
                            </button></a>
                        </div>

                        <div id="classList" class="grid gap-4 p-4 bg-gray-200 rounded-lg w-full dark:bg-gray-800 mt-6">
                            @foreach($classes as $class)
                                <div class="class bg-white p-4 rounded-lg shadow flex justify-between items-center dark:bg-gray-700">
                                    <div class="flex flex-col">
                                        <h3 class="text-3xl font-semibold dark:text-white">{{ $class->class_name }}</h3>
                                        <p class="mt-1 text-gray-600 text-xl dark:text-gray-300"><span class="font-bold">Ano:</span> {{ $class->class_year }}</p>
                                        <a href="{{ route('coordinators.notifications.create.class', ['class_id' => $class->class_id]) }}">
                                            <button class="mt-4 w-36 flex items-center justify-center bg-blue-500 text-white rounded-xl hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 py-3 mb-3">Notificar</button>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <h1 class="pageTitle text-2xl md:text-3xl -mb-8">Notificar Tutores</h1>

                @if($tutors->isEmpty())
                    <h1 class="pageTitle text-2xl md:text-3xl">Não há tutores cadastrados.</h1>
                @else
                    <div class="container mx-auto p-4 py-8">
                        <!-- Linha de pesquisa ocupando todas as 4 colunas -->
                        <div class="col-span-4 flex items-center gap-2">
                            <!-- Campo de pesquisa ocupando 75% -->
                            <input id="searchInput" type="text" placeholder="Pesquisar..." class="flex-grow p-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white mb-3" />

                            <!-- Botão com ícone de + ocupando 25% -->
                            <a href="#"><button class="w-16 font-bold h-full flex items-center justify-center bg-blue-500 text-white rounded-r-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 py-3 mb-3">
                                <i class="fas fa-filter py-1.8"></i>
                            </button></a>
                        </div>

                        <div id="classList" class="grid gap-4 p-4 bg-gray-200 rounded-lg w-full dark:bg-gray-800 mt-6">
                            @foreach($tutors as $tutor)
                                <div class="class bg-white p-4 rounded-lg shadow flex justify-between items-center dark:bg-gray-700">
                                    <div class="flex flex-col">
                                        <h3 class="text-3xl font-semibold dark:text-white">{{ $tutor->tutor_name }}</h3>
                                        <a href="{{ route('coordinators.notifications.create.tutor', ['tutor_id' => $tutor->tutor_user_id]) }}">
                                            <button class="mt-4 w-36 flex items-center justify-center bg-blue-500 text-white rounded-xl hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 py-3 mb-3">Notificar</button>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </main>
    </body>
</x-layout>
