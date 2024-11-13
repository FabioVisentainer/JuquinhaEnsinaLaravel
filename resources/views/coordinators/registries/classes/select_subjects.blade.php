<x-layout>
<body class="body bg-slate-50">
        <nav class="flex justify-between items-center">
        <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
          <div class="max-[770px]:hidden">
            <!-- Div do botao de voltar -->
            <a href="{{ route('coordinators.registries.classes.edit', $class->class_id) }}"><img class="invertColor cursor-pointer pointer-events-auto" src="{{ asset('images/voltar.png') }}" alt="Botao de voltar a pagina" width="40px"></a>
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
        <main>
          <div class="total relative top-1 transition-all duration-300 ease-in-out">
              <div>
                  <h1 class="pageTitle text-4xl md:text-6xl mt-4 text-gray-800 dark:text-white">Selecionar Matéria para Turma: {{ $class->class_name }} - {{ $class->class_year }}</h1>
              </div>
      
              @if ($errors->any())
                  <div class="alert alert-danger mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                      <ul class="list-disc list-inside">
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
      
              <div class="container mx-auto p-4 py-8">
                  <form action="{{ route('coordinators.save_subjects', $class->class_id) }}" method="POST" class="space-y-4">
                      @csrf
      
                      <div id="subjectList" class="grid gap-4 p-4 bg-gray-200 rounded-lg w-full dark:bg-gray-800 mt-6">
                          <div class="subject bg-white p-4 rounded-lg shadow flex flex-col dark:bg-gray-700">
                              <table class="w-full">
                                  <thead class="bg-gradient-to-r from-blue-500 to-blue-400 text-white border-b-2 border-gray-300 dark:border-gray-600">
                                      <tr>
                                          <th class="p-2 text-center">Selecionar</th>
                                          <th class="p-2">Nome do Professor</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                      @foreach($subjects as $subject)
                                          <tr class="border-b border-gray-300 dark:border-gray-600">
                                              <td class="p-2 text-center">
                                                  <input 
                                                      type="checkbox" 
                                                      name="subjects[]" 
                                                      value="{{ $subject->class_subject_id }}" 
                                                      class="form-checkbox h-5 w-5 text-blue-600 dark:bg-gray-800 dark:border-gray-600 focus:ring-blue-500"
                                                      {{ $associatedSubjects->contains('class_subject_id', $subject->class_subject_id) ? 'checked' : '' }}
                                                  >
                                              </td>
                                              <td class="p-2 text-gray-700 dark:text-gray-300">{{ $subject->class_subject_name }}</td>
                                          </tr>
                                      @endforeach
                                  </tbody>
                              </table>
                          </div>
                      </div>
      
                      <div class="flex justify-center mt-6">
                          <button 
                              type="submit" 
                              class="blueButton rounded-xl sm:w-[50%] md:w-[35%] lg:w-[30%] py-3 text-white font-bold text-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                              Atualizar Associação de Matérias
                          </button>
                      </div>
                  </form>
              </div>
          </div>
      </main>
      



    {{-- <h1>Select Subject for Class: {{ $class->class_name }} - {{ $class->class_year }}</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('coordinators.save_subjects', $class->class_id) }}" method="POST">
        @csrf

        <table>
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Teacher Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach($subjects as $subject)
                    <tr>
                        <td>
                            <input type="checkbox" name="subjects[]" value="{{ $subject->class_subject_id }}" 
                            {{ $associatedSubjects->contains('class_subject_id', $subject->class_subject_id) ? 'checked' : '' }}>
                        </td>
                        <td>{{ $subject->class_subject_name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit">Update Subjects Association</button>
    </form> --}}

    {{-- <a href="{{ route('coordinators.registries.classes.edit', $class->class_id) }}">Back to Edit Class</a> --}}
</x-layout>