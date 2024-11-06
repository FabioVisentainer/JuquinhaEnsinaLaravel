<x-layout>
  <nav class="flex justify-between items-center">
    <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
      <div class="max-[770px]:hidden">
        <!-- Div do botao de voltar -->
        <a href="{{ route('coordinators.home') }}"><img class="invertColor cursor-pointer pointer-events-auto" src="{{ asset('images/voltar.png') }}" alt="Botao de voltar a pagina" width="40px"></a>
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
        <img class="hamburger invertColor cursor-pointer transition-all ease-out duration-500 md:hidden block max-[800px]:ml-3" src="../images/hamburger.png" alt="Hamburger" width="45px">
        <img class="x invertColor cursor-pointer hidden transition-all ease-linear duration-500 md:hidden max-[800px]:ml-3" src="../images/x.png" alt="Exit hamburguer" width="30px">
      </div>
  
    <div class="flex gap-8 p-5">
      <!-- Div direita da nav -->
      <div>
        <img class="moon cursor-pointer drop-shadow-[0_0px_16px_rgba(4,15,140)]" src="../images/lua.png" alt="" width="40px">
        <img class="sun cursor-pointer dark:drop-shadow-[0_0px_30px_rgba(255,232,150)] hidden" src="../images/sol.png" alt="" width="40px">
      </div>
      
      <div>
          <a href="{{ route('coordinators.notifications.home') }}">
            <img id="notificationIcon" class="invertColor cursor-pointer" src="{{ asset('images/notificacao.png') }}" alt="Botao de notificacoes" width="40px">
          </a>
      </div>

      <div>
        <img src="../images/skillos.png" alt="Company image" width="40px">
      </div>

    </div>
    </nav>

    <div class="total relative top-1 transition-all duration-300 ease-in-out">
      <div>
        <h1 class="pageTitle">Olá Coordenador!</h1>
      </div>
      <div class="dadCards">
        <div class="card bg-[#FFEEB1] drop-shadow-2xl dark:drop-shadow-[0_0px_30px_rgba(255,232,150,0.5)]">
          <a href="{{ route('coordinators.registries.students.home') }}">
            <img class="p-8" src="{{ asset('images/RegisAluno.png') }}" alt="Professores" width="350px">
            <p class="text-2xl p-2 sm:text-3xl">Cadastros de Alunos</p>
          </a>
        </div>

        <div class="card bg-[#FFEEB1] drop-shadow-2xl dark:drop-shadow-[0_0px_30px_rgba(255,232,150,0.5)]">
          <a href="{{ route('coordinators.registries.tutors.home') }}">
            <img class="p-8" src="{{ asset('images/RegisResponsaveis.png') }}" alt="Professores" width="350px">
            <p class="text-2xl p-2 sm:text-3xl">Cadastros de Responsaveis</p>
          </a>
        </div>

        <div class="card bg-[#FFEEB1] drop-shadow-2xl dark:drop-shadow-[0_0px_30px_rgba(255,232,150,0.5)]">
          <a href="{{ route('coordinators.registries.teachers.home') }}">
            <img class="p-8" src="{{ asset('images/RegisProfessor.png') }}" alt="Professores" width="350px">
            <p class="text-2xl p-2 sm:text-3xl">Cadastros de Docentes</p>
          </a>
        </div>
      </div>
    </div>
  </main>

</x-layout>