<x-layout>
    <body class="body bg-slate-50">
  <nav class="flex justify-between items-center">
  <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
    <div class="max-[770px]:hidden">
      <!-- Div do botao de voltar -->
      <a href="{{ route('Mainhome') }}"><img class="invertColor cursor-pointer pointer-events-auto" src="../images/voltar.png" alt="Botao de voltar a pagina" width="40px"></a>
    </div>
  </div>

  
  <!-- Div esquerda da nav -->

  <div class="pointer-events-none">
    <ul class="navText opacity-0 top-[120px] gap-4">
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
      <img class="hamburger invertColor cursor-pointer transition-all ease-out duration-500 md:hidden block max-[800px]:-ml-60" src="../images/hamburger.png" alt="Hamburger" width="45px">
      <img class="x invertColor cursor-pointer hidden transition-all ease-linear duration-500 md:hidden max-[800px]:-ml-60" src="../images/x.png" alt="Exit hamburguer" width="30px">
    </div>

  <div class="flex gap-8 p-5">
    <!-- Div direita da nav -->
    <div>
      <img class="moon cursor-pointer drop-shadow-[0_0px_16px_rgba(4,15,140)]" src="../images/lua.png" alt="" width="40px">
      <img class="sun cursor-pointer dark:drop-shadow-[0_0px_30px_rgba(255,232,150)] hidden" src="../images/sol.png" alt="" width="40px">
    </div>

    <div>
      <a href="#"><img class="invertColor cursor-pointer" src="../images/notificacao.png" alt="Botao de notificacoes" width="40px"></a>
    </div>

    <div>
      <img src="../images/skillos.png" alt="Company image" width="40px">
    </div>
  </div>
  </nav>
  
    <main>
      <div class="total relative top-1 transition-all duration-300 ease-in-out">
        <div>
          <h1 class="pageTitle">Olá {{ $student->student_name }}!</h1>
        </div>
        <div class="dadCards">
        <div class="card bg-[#FFEEB1] drop-shadow-2xl dark:drop-shadow-[0_0px_30px_rgba(255,232,150,0.5)]">
          <a href="{{ route('students.activity.table') }}">
            <img class="p-8" src="../images/atividades.png" alt="Atividades" width="350px">
            <p class="text-4xl p-2 sm:text-5xl">Atividades</p>
          </a>
        </div>

        <div class="card bg-[#C5B9EF] drop-shadow-2xl dark:drop-shadow-[0_0px_30px_rgba(148,119,252,0.5)]">
          <a href="{{ route('students.homework.table') }}">
            <img class="p-8" src="../images/tarefas.png" alt="Tarefas" width="350px">
            <p class="text-4xl p-2 sm:text-5xl">Tarefas</p>
          </a>
        </div>

        <div class="card bg-[#BEF1EE] drop-shadow-2xl dark:drop-shadow-[0_0px_30px_rgba(176,255,250,0.5)]">
          <a href="{{ route('students.videos.home') }}">
            <img class="p-8" src="../images/videos.png" alt="Videos" width="350px">
            <p class="text-4xl p-2 sm:text-5xl">Videos</p>
          </a>
        </div>
        </div>
      </div>

</x-layout>