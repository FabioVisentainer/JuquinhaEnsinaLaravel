<x-layout>
  <body class="body bg-slate-50">
      <nav class="flex justify-between items-center">
          <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
              <div class="max-[770px]:hidden">
                  <!-- Div do botão de voltar -->
                  <a href="{{ route('students.home') }}">
                      <img class="invertColor cursor-pointer pointer-events-auto" src="{{ asset('images/voltar.png') }}" alt="Botao de voltar a pagina" width="40px">
                  </a>
              </div>
          </div>

          <!-- Div esquerda da nav -->
          <div>
              <ul class="navText opacity-0 top-[-120px] gap-4 sm:pointer-events-auto pointer-events-none">
                  <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
                      <a href="{{ route('students.home') }}">
                          <p class="navTitle">Inicio</p>
                      </a>
                  </li>
                  <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
                      <a href="{{ route('students.activity.table') }}">
                          <p class="navTitle">Atividades</p>
                      </a>
                  </li>
                  <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
                      <a href="{{ route('students.homework.table') }}">
                          <p class="navTitle">Tarefas</p>
                      </a>
                  </li>
                  <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
                      <a href="{{ route('students.videos.home') }}">
                          <p class="navTitle">Videos</p>
                      </a>
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
                  <h1 class="pageTitle">Atividades!</h1>
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
                      @foreach ($AvailableActivities as $activity)
                          <div class="card bg-[#FFEEB1] drop-shadow-2xl dark:drop-shadow-[0_0px_30px_rgba(255,232,150,0.5)]">
                              <!-- Card da atividade -->
                              <a href="{{ asset($activity->activity_url) }}" target="_blank">
                                  <img class="p-8" src="{{ asset('images/atividades.png') }}" alt="Atividades" width="350px">
                                  <p class="text-3xl font-semibold text-center dark:text-white p-4 font-londrina drop-shadow-lg">{{ $activity->activity_name }}</p>
                              </a>
                          </div>
                      @endforeach
                  </div>
              </div>
          </div>

          <script>
              document.getElementById("searchInput").addEventListener("input", function() {
                  const filter = this.value.toLowerCase();
                  const activities = document.querySelectorAll("#attList .activiti");

                  activities.forEach(activiti => {
                      const name = activiti.querySelector("p").textContent.toLowerCase();
                      if (name.includes(filter)) {
                          activiti.style.display = "flex";
                      } else {
                          activiti.style.display = "none";
                      }
                  });
              });
          </script>
      </main>
  </body>
</x-layout>
