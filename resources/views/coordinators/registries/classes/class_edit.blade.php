<x-layout>
  <body class="body bg-slate-50">
          <nav class="flex justify-between items-center">
          <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
            <div class="max-[770px]:hidden">
              <!-- Div do botao de voltar -->
              <a href="{{ route('coordinators.registries.classes.home') }}"><img class="invertColor cursor-pointer pointer-events-auto" src="{{ asset('images/voltar.png') }}" alt="Botao de voltar a pagina" width="40px"></a>
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
  
  
  
  
  
  {{-- <a href="{{ route('coordinators.registries.classes.home') }}">Voltar</a><br><br> --}}
  
  
  
  
  
  
  
  <div class="total relative top-1 transition-all duration-300 ease-in-out">
  
      <h1 class="pageTitle text-4xl md:text-6xl">Editar Turma: {{ $class->class_name }}</h1>
  
      <div class="contCenter flex justify-center">
          <form action="{{ route('coordinators.registries.classes.update', $class->class_id) }}" method="POST" class="form">
              @csrf
              @method('PUT')
  
              <!-- Include the form component for class and pass the class variable -->
              <x-registries.class_form :class="$class" />
  
              <div class="flex justify-center mt-4">
                  <button type="submit" class="blueButton rounded-full px-8 py-3 text-lg">
                      Atualizar Turma
                  </button>
              </div>
          </form>
      </div>
  
  
  
      <div class="total relative top-1 transition-all duration-300 ease-in-out">
          <h2 class="pageTitle text-4xl md:text-6xl mt-8">Cronogramas Associados</h2>
  
          @if($chronograms->isEmpty())
              <h2 class="text-xl text-center mt-4 text-black dark:text-white font-londrina">Nenhum Cronograma associado com esta turma</h2>
              <div class="flex justify-center">
                  <a href="{{ route('coordinators.select_chronograms', $class->class_id) }}" class="blueButton rounded-xl sm:w-[50%] md:w-[35%] lg:w-[20%] text-center">Selecione Cronograma</a>
              </div>
          @else
              <div class="flex justify-center">
                  <a href="{{ route('coordinators.select_chronograms', $class->class_id) }}" class="blueButton rounded-xl sm:w-[50%] md:w-[35%] lg:w-[20%] text-center">Selecione Cronograma</a>
              </div>
              <div class="container mx-auto p-4 py-8">
                  <div class="grid gap-4 p-4 bg-gray-200 rounded-xl w-full dark:bg-gray-800 mt-6">
                      <!-- Adicionando overflow-x-auto para a rolagem lateral -->
                      <div class="overflow-x-auto w-full">
                          <table class="min-w-full bg-white dark:bg-gray-700 rounded-lg shadow overflow-hidden">
                              <thead>
                                  <tr class="bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300">
                                      <th class="py-3 px-6 text-left font-medium">Nome Do Cronograma</th>
                                      <th class="py-3 px-6 text-left font-medium">Data de Criação</th>
                                      <th class="py-3 px-6 text-left font-medium">Ações</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach($chronograms as $chronogram)
                                      <tr class="border-b dark:border-gray-600">
                                          <td class="py-3 px-6">{{ $chronogram->chronogram_name }}</td>
                                          <td class="py-3 px-6">{{ $chronogram->created_at->format('Y-m-d H:i') }}</td>
                                          <td class="py-3 px-6">
                                              <form action="{{ route('coordinators.delete_chronograms', [$class->class_id, $chronogram->chronogram_id]) }}" method="POST" class="inline">
                                                  @csrf
                                                  @method('DELETE')
                                                  <button type="submit" class="text-red-500 hover:text-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">Remover</button>
                                              </form>
                                          </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
          @endif
          
      
          <h2 class="pageTitle text-4xl md:text-6xl mt-8">Professores Associados</h2>
          @if($teachers->isEmpty())
              <p class="text-xl text-center mt-4 text-black dark:text-white font-londrina pb-8">Nenhum professor associado com esta turma.</p>
                  
          <div class="flex justify-center mt-4">
              <a href="{{ route('coordinators.select_teachers', $class->class_id) }}" class="blueButton rounded-xl sm:w-[50%] md:w-[35%] lg:w-[20%] text-center">Selecionar Professor</a>
          </div>
          @else
              
          <div class="flex justify-center mt-4">
              <a href="{{ route('coordinators.select_teachers', $class->class_id) }}" class="blueButton rounded-xl sm:w-[50%] md:w-[35%] lg:w-[20%] text-center">Selecionar Professor</a>
          </div>
              <div class="container mx-auto p-4 py-8">
                  <div class="grid gap-4 p-4 bg-gray-200 rounded-xl w-full dark:bg-gray-800 mt-6">
                      <table class="min-w-full bg-white dark:bg-gray-700 rounded-lg shadow overflow-hidden">
                          <thead>
                              <tr class="bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300">
                                  <th class="py-3 px-6 text-left font-medium">Nome do Professo</th>
                                  <th class="py-3 px-6 text-left font-medium">Acoes</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($teachers as $teacher)
                                  <tr class="border-b dark:border-gray-600">
                                      <td class="py-3 px-6">{{ $teacher->teacher_name }}</td>
                                      <td class="py-3 px-6">
                                          <form action="{{ route('coordinators.delete_teachers', [$class->class_id, $teacher->teacher_user_id]) }}" method="POST" class="inline">
                                              @csrf
                                              @method('DELETE')
                                              <button type="submit" class="text-red-500 hover:text-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">Remover</button>
                                          </form>
                                      </td>
                                  </tr>
                              @endforeach
                          </tbody>
                      </table>
                  </div>
              </div>
          @endif
      
          <h2 class="pageTitle text-4xl md:text-6xl mt-8">Associar Disciplinas</h2>
  
          @if($classsubjects->isEmpty())
              <p class="text-xl text-center mt-4 text-black dark:text-white font-londrina">Nenhuma disciplina associada com esta turma.</p>
              <div class="flex justify-center mt-4">
                  <a href="{{ route('coordinators.select_subjects', $class->class_id) }}" class="blueButton rounded-xl sm:w-[50%] md:w-[35%] lg:w-[20%] text-center">Selecionar Disciplinas</a>
              </div>
          @else
          <div class="flex justify-center mt-4">
              <a href="{{ route('coordinators.select_subjects', $class->class_id) }}" class="blueButton rounded-xl sm:w-[50%] md:w-[35%] lg:w-[20%] text-center">Selecionar Disciplinas</a>
          </div>
              <div class="container mx-auto p-4 py-8">
                  <div class="grid gap-4 p-4 bg-gray-200 rounded-xl w-full dark:bg-gray-800 mt-6">
                      <table class="min-w-full bg-white dark:bg-gray-700 rounded-lg shadow overflow-hidden">
                          <thead>
                              <tr class="bg-gray-100 dark:bg-gray-600 text-gray-700 dark:text-gray-300">
                                  <th class="py-3 px-6 text-left font-medium">Nome da disciplina</th>
                                  <th class="py-3 px-6 text-left font-medium">acoes</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($classsubjects as $classsubject)
                                  <tr class="border-b dark:border-gray-600">
                                      <td class="py-3 px-6">{{ $classsubject->class_subject_name }}</td>
                                      <td class="py-3 px-6">
                                          <form action="{{ route('coordinators.delete_subjects', [$class->class_id, $classsubject->class_subject_id]) }}" method="POST" class="inline">
                                              @csrf
                                              @method('DELETE')
                                              <button type="submit" class="text-red-500 hover:text-red-600 focus:outline-none focus:ring-2 focus:ring-red-500">Remover</button>
                                          </form>
                                      </td>
                                  </tr>
                              @endforeach
                          </tbody>
                      </table>
                  </div>
              </div>
          @endif
      
      </div>
  </div>
  
      {{-- <h2>Cronogramas Associados</h2>
      <br><br>
      @if($chronograms->isEmpty())
          <h2>Associate Chronograms</h2>
          <a href="{{ route('coordinators.select_chronograms', $class->class_id) }}">Select Chronograms</a>
      @else
          <table>
              <thead>
                  <tr>
                      <th>Chronogram Name</th>
                      <th>Create Date</th>
                      <th>Actions</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach($chronograms as $chronogram)
                      <tr>
                          <td>{{ $chronogram->chronogram_name }}</td>
                          <td>{{ $chronogram->created_at->format('Y-m-d H:i') }}</td>
                          <td>
                              <form action="{{ route('coordinators.delete_chronograms', [$class->class_id, $chronogram->chronogram_id]) }}" method="POST">
                                  @csrf
                                  @method('DELETE') <!-- This line is important -->
                                  <button type="submit">Remove</button>
                              </form>
                          </td>
                      </tr>
                  @endforeach
              </tbody>
          </table>
      @endif
  
      <h2>Associate Teachers</h2>
      <a href="{{ route('coordinators.select_teachers', $class->class_id) }}">Select Teachers</a>
      <br><br>
      @if($chronograms->isEmpty())
          <p>No tutors associated with this student.</p>
      @else
          <table>
              <thead>
                  <tr>
                      <th>Teacher Name</th>
                      <th>Actions</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach($teachers as $teacher)
                      <tr>
                          <td>{{ $teacher->teacher_name }}</td>
                          <td>
                              <form action="{{ route('coordinators.delete_teachers', [$class->class_id, $teacher->teacher_user_id]) }}" method="POST">
                                  @csrf
                                  @method('DELETE') <!-- This line is important -->
                                  <button type="submit">Remove</button>
                              </form>
                          </td>
                      </tr>
                  @endforeach
              </tbody>
          </table>
      @endif
  
      <h2>Associar Disciplinas</h2>
      <a href="{{ route('coordinators.select_subjects', $class->class_id) }}">Select Subjects</a>
      <br><br>
      @if($classsubjects->isEmpty())
          <p>No subjects associated with this class.</p>
      @else
          <table>
              <thead>
                  <tr>
                      <th>Subject Name</th>
                      <th>Actions</th>
                  </tr>
              </thead>
              <tbody>
                  @foreach($classsubjects as $classsubject)
                      <tr>
                          <td>{{ $classsubject->class_subject_name }}</td>
                          <td>
                              <form action="{{ route('coordinators.delete_subjects', [$class->class_id, $classsubject->class_subject_id]) }}" method="POST">
                                  @csrf
                                  @method('DELETE') <!-- This line is important -->
                                  <button type="submit">Remove</button>
                              </form>
                          </td>
                      </tr>
                  @endforeach
              </tbody>
          </table>
      @endif
   --}}
  
  
      <x-errors />
  </x-layout>