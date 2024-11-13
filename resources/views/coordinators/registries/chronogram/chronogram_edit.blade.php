<x-layout>
<body class="body bg-slate-50">
        <nav class="flex justify-between items-center">
        <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
          <div class="max-[770px]:hidden">
            <!-- Div do botao de voltar -->
            <a href="{{ route('coordinators.registries.chronograms.home') }}"><img class="invertColor cursor-pointer pointer-events-auto" src="{{ asset('images/voltar.png') }}" alt="Botao de voltar a pagina" width="40px"></a>
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





<a href="{{ route('coordinators.registries.chronograms.home') }}">Voltar</a><br><br>






<div class="total relative top-1 transition-all duration-300 ease-in-out flex justify-center items-center min-h-full p-4">
  <div class="w-full max-w-lg bg-gray-200 p-6 rounded-lg shadow-lg dark:bg-gray-800 border border-gray-300">
      <h1 class="text-3xl font-bold text-center mb-4 dark:text-white">Edit Chronogram: {{ $chronogram->chronogram_name }}</h1>

    <form action="{{ route('coordinators.registries.chronograms.update', $chronogram->chronogram_id) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Include the form component for chronogram and pass the chronogram data -->
        <x-registries.chronogram_form :chronogram="$chronogram" />

        <div class="flex justify-center mt-4">
          <button type="submit" class="btn bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors duration-300">Update Chronogram</button>
        </div>
    </form>
  </div>
</div>


    <h2>Associate Homeworks</h2>
    <a href="{{ route('coordinators.select_homeworks', $chronogram->chronogram_id) }}">Select Homeworks</a>

    <br><br>
    

    @if($associatedHomeworks->isEmpty())
        <p>No homeworks associated with this chronogram.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>Homework Name</th>
                    <th>Release Date</th>
                    <th>Due Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($associatedHomeworks as $associatedHomework)
                    <tr>
                        <td>{{ $associatedHomework->homework_name }}</td>
                        <td>{{ $associatedHomework->pivot->release_date }}</td>
                        <td>{{ $associatedHomework->pivot->due_date }}</td>
                        <td>
                            <form action="{{ route('coordinators.delete_homework', [$chronogram->chronogram_id, $associatedHomework->homework_id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <x-errors />
</x-layout>