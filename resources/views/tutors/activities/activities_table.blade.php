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
        <main>
            <div class="total relative top-1 transition-all duration-300 ease-in-out">
                <div>
                    <h1 class="pageTitle">Tarefas!</h1>
                </div>

              <div class="container mx-auto p-4 py-8">
                  <div class="flex items-center gap-2 mb-4">
                      <input 
                          type="text" 
                          id="searchInput"
                          placeholder="Pesquisar..."
                          class="flex-grow p-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white mb-3"
                      />
                      <button class="w-16 font-bold h-full flex items-center justify-center bg-blue-500 text-white rounded-r-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 py-3 mb-3">
                          <i class="fas fa-filter py-1.8"></i>
                      </button>
                  </div>   
                                  <!-- Container flexível para as atividades -->
                    <div id="attList" class="dadCards">
                        @foreach ($activities as $activity)
                            <div class="card bg-[#C5B9EF] drop-shadow-2xl dark:drop-shadow-[0_0px_30px_rgba(148,119,252,0.5)]">
                                <!-- Card da atividade -->
                                <a>
                                <img class="p-8" src="{{ asset('images/tarefas.png') }}" alt="Atividades" width="350px">
                                <p class="text-4xl font-semibold text-center dark:text-white pb-3 pd-4 pl-4 pt-1 font-londrina drop-shadow-lg">{{ $activity->activity_name }}</p>
                                <p class="text-2xl font-semibold text-center pb-1 pd-4 pl-4 pt-1 drop-shadow-lg font-londrina {{ $activity->status === 'Completed' ? 'text-green-300' : 'text-red-300' }}">
                                    {{ $activity->status }}
                                </p>
                                <p class="text-2xl font-semibold text-center dark:text-white pb-1 pd-4 pl-4 pt-1 font-londrina drop-shadow-lg">Completado {{ $activity->times_completed ?: '0' }} vezes</p>
                                <p class="text-2xl font-semibold text-center dark:text-white pb-1 pd-4 pl-4 pt-1 font-londrina drop-shadow-lg">Feito em: {{ $activity->last_completed_time ?? 'N/A' }}</p>

                                </a>
                            </div>
                        @endforeach
                    </div>
                    <script>
                  document.getElementById("searchInput").addEventListener("input", function() {
                      const filter = this.value.toLowerCase();
                      const atts = document.querySelectorAll("#attList .card");

                      atts.forEach(card => {
                          const name = card.querySelector("p").textContent.toLowerCase();
                          if (name.includes(filter)) {
                              card.style.display = "flex";
                          } else {
                              card.style.display = "none";
                          }
                      });
                  });
              </script>
                </div>
            </div>  

        </main>

</x-layout>