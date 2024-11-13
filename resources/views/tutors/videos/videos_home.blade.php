<x-layout>
    <body class="body bg-slate-50">
        <nav class="flex justify-between items-center">
            <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
                <div class="max-[770px]:hidden">
                    <!-- Div do botao de voltar -->
                    <a href="{{ route('tutors.home', [$studentUserId]) }}">
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
    

    {{-- <div class="container">
        <h1>Videos</h1>

        <ul class="list-group mt-3">
            @foreach($videos as $video)
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="d-flex flex-column">
                        <span>
                            {{ $video->video_name }}
                        </span>
                        <br>
                        <iframe 
                            width="200" 
                            height="113" 
                            src="https://www.youtube.com/embed/{{ \App\Services\VideoService::extractYoutubeId($video->video_url) }}" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                    </div>
                </li>
            @endforeach
        </ul> --}}

        <main>
            <div class="total relative top-1 transition-all duration-300 ease-in-out">
              <div>
                <h1 class="pageTitle">Videos Disponiveis!</h1>
              </div>
    
              <div class="container mx-auto p-4 py-8">
                <div class="flex items-center gap-2 mb-4">
                    <input 
                        type="text" 
                        placeholder="Pesquisar..." 
                        id = "searchInput"
                        class="flex-grow p-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white mb-3" 
                    />
                    <button class="w-16 font-bold h-full flex items-center justify-center bg-blue-500 text-white rounded-r-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 py-3 mb-3">
                        <i class="fas fa-filter py-1.8"></i>
                    </button>
                </div>
            
                <!-- Container flexível para os vídeos -->
                <div id="videoList" class="dadCards">
                      @foreach($videos as $video)
                          <div class="cardVideo bg-[#B9CAEF] drop-shadow-2xl dark:drop-shadow-[0_0px_30px_rgba(0, 102, 204, 0.5)] p-3 w-[500px] h-[400px] p-4 mt-4">
                              <!-- Contêiner arredondado com padding -->
                              <div class="overflow-hidden rounded-2xl">
                                  <iframe 
                                      width="100%" 
                                      height="300" 
                                      src="https://www.youtube.com/embed/{{ \App\Services\VideoService::extractYoutubeId($video->video_url) }}" 
                                      frameborder="0" 
                                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                      allowfullscreen
                                      class="w-full h-300"
                                  ></iframe>
                              </div>
                  
                              <!-- Título do vídeo alinhado na parte inferior -->
                              <p class="text-2xl font-semibold text-center mt-4 dark:text-white font-londrina drop-shadow-lg">{{ $video->video_name }}</p>
                          </div>
                      @endforeach
                  </div>

                <script>
                    document.getElementById("searchInput").addEventListener("input", function() {
                      const filter = this.value.toLowerCase();
                      const videos = document.querySelectorAll("#videoList .cardVideo");

                      videos.forEach(video => {
                        const name = video.querySelector("p").textContent.toLowerCase();
                        if (name.includes(filter)) {
                          video.style.display = "flex";
                        } else {
                          video.style.display = "none";
                        }
                      });
                    });
                </script>
        </main>

</x-layout>