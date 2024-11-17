<x-layout>
  <body class="body bg-slate-50">
          <nav class="flex justify-between items-center">
          <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
            <div class="max-[770px]:hidden">
              <!-- Div do botao de voltar -->
              <a href="{{ route('coordinators.registries.classessubjects.home') }}"><img class="invertColor cursor-pointer pointer-events-auto" src="{{ asset('images/voltar.png') }}" alt="Botao de voltar a pagina" width="40px"></a>
            </div>
          </div>
        
          
          <!-- Div esquerda da nav -->
        
          <div class="">
            <ul class="navText opacity-0 top-[120px] gap-4 sm:pointer-events-auto pointer-events-none">
            <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
              <a href="{{ route('coordinators.home') }}"><p class="navTitle">Inicio</p></a>
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
              <img class="x invertColor cursor-pointer hidden transition-all ease-linear duration-500 md:hidden max-[800px]:ml-3" src="{{ asset('images/x.png') }}" alt="Exit hamburguer" width="30px">
            </div>
        
          <div class="flex gap-8 p-5">
            <!-- Div direita da nav -->
            <div>
              <img class="moon cursor-pointer drop-shadow-[0_0px_16px_rgba(4,15,140)]" src="{{ asset('images/lua.png') }}" alt="" width="40px">
              <img class="sun cursor-pointer dark:drop-shadow-[0_0px_30px_rgba(255,232,150)] hidden" src="{{ asset('images/sol.png') }}" alt="" width="40px">
            </div>
            
            <div>
                <a href="{{ route('coordinators.notifications.home') }}">
                  <img id="notificationIcon" class="invertColor cursor-pointer" src="{{ asset('images/notificacao.png') }}" alt="Botao de notificacoes" width="40px">
                </a>
            </div>
        
            <div>
              <img src="{{ asset('images/skillos.png') }}" alt="Company image" width="40px">
            </div>
        
          </div>
          </nav>
  
  
  
  
  {{-- <a href="{{ route('coordinators.registries.classessubjects.home') }}">Voltar</a><br><br> --}}
  
  
  
  
  <div class="total relative top-1 transition-all duration-300 ease-in-out">
  
    <h1 class="pageTitle text-4xl md:text-6xl">Registrar Nova Disciplina</h1>
  
    <div class="contCenter flex justify-center">
        <form action="{{ route('coordinators.registries.classessubjects.store') }}" method="POST" class="form">
            @csrf
  
            <!-- Include the form component -->
            <x-registries.class_subjects_form />
  
            <div class="flex justify-center mt-4">
                <button type="submit" class="blueButton rounded-full px-8 py-3 text-lg">
                    Registrar
                </button>
            </div>
        </form>
    </div>
  </div>
  
  
      {{-- <h1>Register New Class Subject</h1>
  
      <form action="{{ route('coordinators.registries.classessubjects.store') }}" method="POST">
          @csrf
  
          <!-- Include the form component -->
          <x-registries.class_subjects_form />
  
          <button type="submit">Register Class Subject</button>
      </form> --}}
  
      <x-errors />
  </x-layout>