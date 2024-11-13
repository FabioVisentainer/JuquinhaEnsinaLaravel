<x-layout>
    <body class="body bg-slate-50">
        <nav class="flex justify-between items-center">
            <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
                <div class="max-[770px]:hidden">
                    <!-- Div do botao de voltar -->
                    <a href="{{ route('students.home') }}">
                        <img class="invertColor cursor-pointer pointer-events-auto" src="{{ asset('images/voltar.png') }}" alt="Botao de voltar a pagina" width="40px">
                    </a>
                </div>
            </div>

            <!-- Div esquerda da nav -->
            <div class="">
                <ul class="navText opacity-0 top-[-120px] gap-4 sm:pointer-events-auto pointer-events-none">
                    <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
                        <a href="{{ route('students.home') }}"><p class="navTitle">Inicio</p></a>
                    </li>
                    <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
                        <a href="{{ route('students.activity.table') }}"><p class="navTitle">Atividades</p></a>
                    </li>
                    <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
                        <a href="{{ route('students.homework.table') }}"><p class="navTitle">Tarefas</p></a>
                    </li>
                    <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
                        <a href="{{ route('students.videos.home') }}"><p class="navTitle">Videos</p></a>
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
                    <h1 class="pageTitle">Tarefas Disponiveis</h1>
                </div>
                <div class="dadCards">
                    @foreach ($AvailableHomeworks as $homework)
                        <div class="card bg-[#C5B9EF] drop-shadow-2xl dark:drop-shadow-[0_0px_30px_rgba(148,119,252,0.5)]">
                            <a href="{{ asset($homework->homework_url) }}" target="_blank">
                                <img class="p-8" src="../images/tarefas.png" alt="Tarefas" width="350px">
                                <p class="text-4xl p-2 sm:text-5xl drop-shadow-lg">{{ $homework->homework_name }}</p>
                                <p class="text-2xl p-2 sm:text-3xl drop-shadow-lg">{{ $homework->description }}</p>
                                <p class="text-xl p-2 sm:text-2xl text-yellow-100 drop-shadow-lg">De: {{ $homework->release_date ?? 'N/A' }}</p>
                                <p class="text-xl p-2 sm:text-2xl text-red-200 drop-shadow-lg">Para: {{ $homework->due_date ?? 'N/A' }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div>
                    <h1 class="pageTitle">Tarefas Completas</h1>
                </div>
                <div class="dadCards">
                    @foreach ($CompleteHomeworks as $completedHomework)
                        <div class="card bg-[#C5B9EF] drop-shadow-2xl dark:drop-shadow-[0_0px_30px_rgba(148,119,252,0.5)]">
                            <a href="{{ asset($homework->homework_url) }}" target="_blank">
                                <img class="p-8" src="../images/tarefas.png" alt="Tarefas" width="350px">
                                <p class="text-4xl p-2 sm:text-4xl drop-shadow-lg">{{ $completedHomework->homework_id }}</p>
                                <p class="text-xl p-2 sm:text-2xl text-green-100 drop-shadow-lg">Feito em: {{ $completedHomework->updated_at ?? 'N/A' }}</p>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>
    </body>
</x-layout>
