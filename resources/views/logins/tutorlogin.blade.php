<x-layout>
<body class="body bg-slate-50">    
    <nav class="flex justify-between items-center"> 
      <div class="p-5 md:flex md:justify-between">
          <div class=""> <!-- Div do botao de voltar -->
            <a href="{{ route('Mainhome') }}"><img class="invertColor cursor-pointer" src="../images/voltar.png" alt="Botao de voltar a pagina" width="40px"></a>
          </div>
      </div>  

      <img class="hamburger invertColor cursor-pointer transition-all ease-out duration-500 md:hidden block max-[800px]:ml-3 opacity-0" src="./images/hamburger.png" alt="Hamburger" width="45px">
      <img class="x invertColor cursor-pointer hidden transition-all ease-linear duration-500 md:hidden max-[800px]:ml-3 opacity-0" src="./images/x.png" alt="Exit hamburguer" width="30px">
        
      <div class="flex gap-8 p-5"> <!-- Div direita da nav -->
        <div>
          <img class="moon cursor-pointer drop-shadow-[0_0px_16px_rgba(4,15,140)]" src="../images/lua.png" alt="" width="40px">
          <img class="sun cursor-pointer dark:drop-shadow-[0_0px_30px_rgba(255,232,150)] hidden" src="../images/sol.png" alt="" width="40px">
        </div>

        <div>
          <img src="../images/skillos.png" alt="Company image" width="40px">
        </div>
      </div>
    </nav>

    <main>
      <div class="total relative top-1 transition-all duration-300 ease-in-out">
        <div class="flex flex-col items-center justify-center gap-4 my-16">
          <img src="../images/perfil.png" alt="Imagem do Perfil" width="250px" class="invertColor">
          <h1 class="text-6xl font-bold invertColor font-londrina">Responsável</h1>
    <form method="POST" action="{{ route('login.tutor.submit') }}" class="flex flex-col items-center gap-5 w-[80%] sm:w-[60%] md:w-[35%] lg:w-[20%]"> 
        @csrf
        <x-logins.loginform />
        <div class="flex items-center gap-2 w-full">
              <input type="checkbox" name="" id="" class="ml-3">
              <label for="" class="invertColor font-londrina">Lembrar minha senha</label>
        </div>
        <input type="submit" value="Entrar" class="text-2xl font-londrina p-2 mt-4 bg-blue-500 text-white hover:bg-blue-600 rounded-full transition-all duration-300 ease-in-out w-full">
        
    </form>
    
    <x-errors />

</x-layout>