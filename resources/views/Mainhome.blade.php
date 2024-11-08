<x-layout>
<!-- chamada do viwer da pasta "views/components/layout.blade.php"s -->

    <nav class="flex justify-between items-center">
      <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
      </div>
      <!-- Div esquerda da nav -->
      <img class="hamburger invertColor cursor-pointer transition-all ease-out duration-500 opacity-0 block max-[800px]:ml-3" src="./images/hamburger.png" alt="Hamburger" width="45px">
      <img class="x invertColor cursor-pointer transition-all ease-linear duration-500 opacity-0 max-[800px]:ml-3" src="./images/x.png" alt="Exit hamburguer" width="30px">
  
      <div class="flex gap-8 p-5">
        <!-- Div direita da nav -->
        <div>
          <img class="moon cursor-pointer drop-shadow-[0_0px_16px_rgba(4,15,140)]" src="./images/lua.png" alt="" width="40px">
          <img class="sun cursor-pointer dark:drop-shadow-[0_0px_30px_rgba(255,232,150)] hidden" src="./images/sol.png" alt="" width="40px">
        </div>
  
        <div>
          <img src="./images/skillos.png" alt="Company image" width="40px">
        </div>
      </div>
    </nav>
  
    <main>
      <div class="total relative top-1 transition-all duration-300 ease-in-out">
        <div>
          <h1 class="pageTitle">Escolha o seu USUARIO</h1>
        </div>
        <div class="dadCards">
          <div class="card bg-[#FFEEB1] drop-shadow-2xl dark:drop-shadow-[0_0px_30px_rgba(255,232,150,0.5)]">
            <a href="{{ route('login.tutor') }}"><img class="p-8" src="./images/Responsaveis.png" alt="Responsaveis" width="350px"><p class="text-4xl p-2 sm:text-5xl">Responsaveis</p></a>
          </div>
  
          <div class="card bg-[#C5B9EF] drop-shadow-2xl dark:drop-shadow-[0_0px_30px_rgba(148,119,252,0.5)]">
            <a href="{{ route('login.student') }}"><img class="p-8" src="./images/aluno.png" alt="Responsaveis" width="350px"><p class="text-5xl p-2 sm:text-6xl">Alunos</p></a>
          </div>
  
          <div class="card bg-[#BEF1EE] drop-shadow-2xl dark:drop-shadow-[0_0px_30px_rgba(176,255,250,0.5)]">
            <a href="{{ route('login.teacher') }}"><img class="p-8" src="./images/Professores.png" alt="Responsaveis" width="350px"><p class="text-4xl p-2 sm:text-5xl">Docentes</p></a>
          </div>
        </div>
      </div>
    </main>


</x-layout>