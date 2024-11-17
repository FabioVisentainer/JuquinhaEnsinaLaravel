<x-layout>
  <body class="body bg-slate-50">
      <nav class="flex justify-between items-center">
          <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
              <div class="max-[770px]:hidden">
                  <!-- Botão de voltar -->
                  <a href="{{ route('coordinators.registries.tutors.home') }}">
                      <img class="invertColor cursor-pointer pointer-events-auto" src="{{ asset('images/voltar.png') }}" alt="Botão de voltar à página" width="40px">
                  </a>
              </div>
          </div>

          <!-- Menu à esquerda da navegação -->
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
              <img class="x invertColor cursor-pointer hidden transition-all ease-linear duration-500 md:hidden max-[800px]:ml-3" src="{{ asset('images/x.png') }}" alt="Sair do menu hamburger" width="30px">
          </div>

          <div class="flex gap-8 p-5">
              <!-- Menu à direita da navegação -->
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
              <div>
                  <h1 class="pageTitle text-4xl md:text-6xl">Registrar novo Responsável</h1>
              </div>
              <div class="contCenter">
                  <img src="{{ asset('images/perfil.png') }}" alt="Imagem do Perfil" width="250px" class="invertColor">
                  <form action="{{ route('coordinators.registries.tutors.store') }}" method="POST" class="form">
                      @csrf
                      <x-registries.tutor_form />
                      <input type="submit" value="Registrar Responsável" class="blueButton rounded-full sm:w-[90%] md:w-[75%] lg:w-[70%]">
                  </form>
              </div>
          </div>

          <x-errors />
      </main>
  </body>
</x-layout>
