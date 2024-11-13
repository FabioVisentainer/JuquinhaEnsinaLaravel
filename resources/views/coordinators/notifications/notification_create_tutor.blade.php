<x-layout>
<body class="body bg-slate-50">
        <nav class="flex justify-between items-center">
        <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
          <div class="max-[770px]:hidden">
            <!-- Div do botao de voltar -->
            <a href="{{ route('coordinators.notifications.home') }}"><img class="invertColor cursor-pointer pointer-events-auto" src="{{ asset('images/voltar.png') }}" alt="Botao de voltar a pagina" width="40px"></a>
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

        <div class="total relative top-1 transition-all duration-300 ease-in-out flex justify-center items-center min-h-full p-4">
    <div class="w-full max-w-lg bg-gray-200 p-6 rounded-lg shadow-lg dark:bg-gray-800 border border-gray-300">
        <h1 class="text-3xl font-bold text-center mb-4 dark:text-white">Notificação Para {{ $tutor->tutor_name }}</h1>

        @if ($errors->any())
            <div class="alert alert-danger bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-lg dark:bg-red-800 dark:border-red-600">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-sm dark:text-red-300">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('coordinators.notifications.store.tutor', ['tutor_id' => $tutor->tutor_user_id]) }}" method="POST">
            @csrf

            <div class="form-group mb-4">
                <label for="notification_title" class="block text-lg font-semibold dark:text-gray-200">Título da Notificação</label>
                <input type="text" name="notification_title" id="notification_title" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required>
            </div>

            <div class="form-group mb-4">
                <label for="notifications_message" class="block text-lg font-semibold dark:text-gray-200">Mensagem da Notificação</label>
                <textarea name="notifications_message" id="notifications_message" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white" required></textarea>
            </div>

            <input type="hidden" name="entity_id" value="{{ Auth::user()->entity_id }}">
            <input type="hidden" name="from_user_id" value="{{ Auth::id() }}">

            <div class="flex justify-center">
                <button type="submit" class="btn bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-300">Enviar Notificação</button>
            </div>
        </form>
    </div>
</div>



    <!-- <a href="{{ route('coordinators.notifications.home') }}">Voltar</a><br><br> -->
    <!-- <h1>Notificação Para {{ $tutor->tutor_name }}</h1>




    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('coordinators.notifications.store.tutor', ['tutor_id' => $tutor->tutor_user_id]) }}" method="POST">
        @csrf
        
        <div class="form-group">
            <label for="notification_title">Título da Notificação</label>
            <input type="text" name="notification_title" id="notification_title" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="notifications_message">Mensagem da Notificação</label>
            <textarea name="notifications_message" id="notifications_message" class="form-control" required></textarea>
        </div>

        <input type="hidden" name="entity_id" value="{{ Auth::user()->entity_id }}">
        <input type="hidden" name="from_user_id" value="{{ Auth::id() }}">

        <button type="submit" class="btn btn-primary">Enviar Notificação</button>
    </form> -->

    <x-errors />
</x-layout>