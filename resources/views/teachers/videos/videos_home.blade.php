<x-layout>
    {{-- <a href="{{ route('teachers.home') }}">Voltar</a><br><br> --}}
    <body class="body bg-slate-50">
        <nav class="flex justify-between items-center">
        <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
          <div class="max-[770px]:hidden">
            <!-- Div do botao de voltar -->
            <a href="{{ route('teachers.home') }}"><img class="invertColor cursor-pointer pointer-events-auto" src="{{ asset('images/voltar.png') }}" alt="Botao de voltar a pagina" width="40px"></a>
          </div>
        </div>
      
        
        <!-- Div esquerda da nav -->
      
        <div class="">
          <ul class="navText opacity-0 top-[120px] gap-4 sm:pointer-events-auto pointer-events-none">
          <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
            <a href="{{ route('teachers.home') }}"><p class="navTitle">Inicio</p></a>
          </li>
          <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
            <a href="{{ route('teachers.activity.home') }}"><p class="navTitle">Liberar Atividades</p></a>
          </li>
          <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
            <a href="{{ route('teachers.homework.home') }}"><p class="navTitle">Liberar Tarefas</p></a>
          </li>
          <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
            <a href="{{ route('teachers.frequency.home') }}"><p class="navTitle">Registrar Frequência</p></a>
          </li>
          <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
            <a href="{{ route('teachers.grades.home') }}"><p class="navTitle">Registrar Boletim</p></a>
          </li>
          <li class="max-[1200px]:mx-1 z-10 mx-4 my-6 md:my-0">
            <a href="{{ route('teachers.videos.home') }}"><p class="navTitle">Enviar Videos</p></a>
          </li>
        </ul>
        </div>
        
       
          <div>
            <img class="hamburger invertColor cursor-pointer transition-all ease-out duration-500 md:hidden block max-[800px]:ml-3" src="{{ asset('images/hamburger.png') }}" width="45px">
            <img class="x invertColor cursor-pointer hidden transition-all ease-linear duration-500 md:hidden max-[800px]:ml-3" src="{{ asset('images/x.png') }}" width="30px">
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
            <div class="total relative top-1 transition-all duration-300 ease-in-out min-h-screen flex flex-col items-center justify-center">

                <!-- Título e botão de "Voltar" -->
                <div class="flex justify-between items-center w-full max-w-6xl mb-4 px-4">
                    {{-- <a href="{{ route('teachers.home') }}" class="text-blue-500 hover:underline">Voltar</a> --}}
                    <h1 class="pageTitle text-4xl md:text-6xl">Enviar Videos</h1>
                </div>
        
                @if(session('success'))
                    <div class="alert alert-success mb-4 w-full max-w-6xl px-4">
                        {{ session('success') }}
                    </div>
                @endif
        
                <!-- Formulário de Adicionar Vídeo -->
                <form action="{{ route('teachers.videos.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-lg dark:bg-gray-700 dark:drop-shadow-[0_0px_30px_rgba(0, 102, 204, 0.3)] mb-8 w-full max-w-6xl px-4">
                    @csrf
                    <div class="grid gap-4 sm:grid-cols-1 md:grid-cols-2">
                        <!-- Campo para o nome do vídeo -->
                        <div class="form-group">
                            <label for="video_name" class="text-xl dark:text-white">Nome do Video</label>
                            <input type="text" name="video_name" class="form-control p-3 border border-gray-300 rounded-lg w-full dark:bg-gray-800 dark:text-white dark:border-gray-700" required>
                        </div>
                        
                        <!-- Campo para a URL do vídeo -->
                        <div class="form-group">
                            <label for="video_url" class="text-xl dark:text-white">URL do Video</label>
                            <input type="url" name="video_url" class="form-control p-3 border border-gray-300 rounded-lg w-full dark:bg-gray-800 dark:text-white dark:border-gray-700" required>
                            @error('video_url')
                                <div class="text-red-500">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
        
                    <!-- Botão de Adicionar Vídeo -->
                    <button type="submit" class="btn btn-primary bg-blue-500 text-white hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded-lg py-3 px-6 mt-4">Add Video</button>
                </form>
        
                <!-- Exibição de vídeos existentes -->
                <h2 class="text-3xl mb-4 text-gray-800 dark:text-white font-londrina">Videos Existentes</h2>
                <div class="grid gap-6 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 w-full max-w-6xl px-4">
                    @foreach($videos as $video)
                        <div class="bg-white p-4 rounded-lg shadow dark:bg-gray-700">
                            <div class="d-flex flex-column">
                                <h3 class="text-xl font-semibold dark:text-white">{{ $video->video_name }}</h3>
                                <iframe 
                                    width="200" 
                                    height="113" 
                                    src="https://www.youtube.com/embed/{{ \App\Services\VideoService::extractYoutubeId($video->video_url) }}" 
                                    frameborder="0" 
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                    allowfullscreen class="mt-2">
                                </iframe>
                            </div>
        
                            <!-- Formulário para excluir o vídeo -->
                            <form action="{{ route('teachers.videos.delete', $video->video_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this video?');" class="mt-4">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger bg-red-500 text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 rounded-lg py-2 px-4">Deletar</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>

    {{-- <div class="container">
        <h1>Your Videos</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('teachers.videos.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="video_name">Video Name</label>
                <input type="text" name="video_name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="video_url">Video URL</label>
                <input type="url" name="video_url" class="form-control" required>
                @error('video_url')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary">Adicionar Vídeo</button>
        </form>

        <h2 class="mt-4">Existing Videos</h2>
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
                    <form action="{{ route('teachers.videos.delete', $video->video_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this video?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </li>
            @endforeach
        </ul> --}}

</x-layout>