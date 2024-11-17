<x-layout>
  <body class="body bg-slate-50">
    <nav class="flex justify-between items-center">
      <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
        <div class="max-[770px]:hidden">
          <!-- Div do botão de voltar -->
          <a href="{{ route('coordinators.registries.home') }}"><img class="invertColor cursor-pointer pointer-events-auto" src="{{ asset('images/voltar.png') }}" alt="Botão de voltar a página" width="40px"></a>
        </div>
      </div>
      
      <!-- Div esquerda da nav -->
      <div class="">
        <ul class="navText opacity-0 top-[120px] gap-4 sm:pointer-events-auto pointer-events-none">
          <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
            <a href="{{ route('coordinators.home') }}"><p class="navTitle">Início</p></a>
          </li>
          <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
            <a href="{{ route('coordinators.registries.home') }}"><p class="navTitle">Cadastros</p></a>
          </li>
          <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
            <a href="{{ route('coordinators.registries.classes.home') }}"><p class="navTitle">Turmas</p></a>
          </li>
          <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
            <a href="{{ route('coordinators.registries.classessubjects.home') }}"><p class="navTitle">Disciplinas</p></a>
          </li>
          <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
            <a href="{{ route('coordinators.registries.chronograms.home') }}"><p class="navTitle">Cronogramas</p></a>
          </li>
          <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
            <a href="{{ route('coordinators.reports.home') }}"><p class="navTitle">Relatórios</p></a>
          </li>
        </ul>
      </div>
  
      <div>
        <img class="hamburger invertColor cursor-pointer transition-all ease-out duration-500 md:hidden block max-[800px]:ml-3" src="{{ asset('images/hamburger.png') }}" alt="Hamburger" width="45px">
        <img class="x invertColor cursor-pointer hidden transition-all ease-linear duration-500 md:hidden max-[800px]:ml-3" src="{{ asset('images/x.png') }}" alt="Fechar hamburger" width="30px">
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

    <div class="total relative top-1 transition-all duration-300 ease-in-out">
      <h1 class="pageTitle text-4xl md:text-6xl">Cadastro de Professores</h1>
      @if(session('success'))
        <div class="alert alert-success">
          {{ session('success') }}
        </div>
      @endif

      @if($teachers->isEmpty())
        <h1 class="pageTitle text-2xl md:text-3xl">Não tem Professores cadastrados na sua entidade</h1>
      @else
        <div class="container mx-auto p-4 py-8">
          <!-- Linha de pesquisa ocupando todas as 4 colunas -->
          <div class="col-span-4 flex items-center gap-2">
            <!-- Campo de pesquisa ocupando 75% -->
            <input 
              id="searchInput"
              type="text" 
              placeholder="Pesquisar..." 
              class="flex-grow p-2 border border-gray-300 rounded-l-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:text-white mb-3" 
            />
            <!-- Botão com ícone de + ocupando 25% -->
            <a href="#"><button 
              class="w-16 font-bold h-full flex items-center justify-center bg-blue-500 text-white rounded-r-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 py-3 mb-3">
              <i class="fas fa-filter py-1.8"></i>
            </button></a>
          </div> 
  
          <div class="flex justify-center items-center">
            <button class="blueButton rounded-xl sm:w-[50%] md:w-[35%] lg:w-[30%] "><a href="{{ route('coordinators.registries.teachers.new') }}">Cadastrar novo Docente</a></button>
          </div>

          <div id="teacherList" class="grid gap-4 p-4 bg-gray-200 rounded-lg w-full dark:bg-gray-800 mt-6">
            @foreach($teachers as $teacher)
              <div class="teacher bg-white p-4 rounded-lg shadow flex justify-between items-center dark:bg-gray-700">
                <div class="flex flex-col">
                  <h3 class="text-3xl font-semibold dark:text-white">{{ $teacher->teacher_name }}</h3>
                  <p class="mt-1 ml-0.5 text-gray-600 text-xl dark:text-gray-300"><span class="font-bold">Status:</span> {{ $teacher->is_active ? 'Ativo' : 'Inativo' }}</p>
                  <p class="mt-1 ml-0.5 text-gray-600 text-xl dark:text-gray-300"><span class="font-bold">Coordenador?</span> {{ $teacher->coordinator}}</p>
                  <p class="text-gray-600 md:hidden dark:text-gray-300"><span class="font-bold ml-0.5">Data de Registro:</span> {{ $teacher->teacher_registry_date }}</p>
                  <a href="{{ route('coordinators.registries.teachers.edit', $teacher->teacher_id) }}"><button class="mt-4 w-36 flex items-center justify-center bg-blue-500 text-white rounded-xl hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 py-3 mb-3">Editar</button></a> 
                </div>
                <div class="hidden md:flex items-center text-gray-600 dark:text-gray-300">
                  <p><span class="font-bold">Data de Registro:</span> {{ $teacher->teacher_registry_date }}</p>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      @endif
    </div>

    <script>
      document.getElementById("searchInput").addEventListener("input", function() {
        const filter = this.value.toLowerCase();
        const teachers = document.querySelectorAll("#teacherList .teacher");

        teachers.forEach(teacher => {
          const name = teacher.querySelector("h3").textContent.toLowerCase();
          if (name.includes(filter)) {
            teacher.style.display = "flex";
          } else {
            teacher.style.display = "none";
          }
        });
      });
    </script>
  </body>
</x-layout>
