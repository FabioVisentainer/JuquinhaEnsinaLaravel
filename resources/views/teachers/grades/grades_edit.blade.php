<x-layout>
<body class="body bg-slate-50">
        <nav class="flex justify-between items-center">
        <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
          <div class="max-[770px]:hidden">
            <!-- Div do botao de voltar -->
            <a href="{{ route('teachers.grades.table', $classId) }}"><img class="invertColor cursor-pointer pointer-events-auto" src="{{ asset('images/voltar.png') }}" alt="Botao de voltar a pagina" width="40px"></a>
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
            <img src="{{ asset('images/skillos.png') }}" alt="Company image" width="40px">
          </div>
        </div>
        </nav>

        <main>
          <div class="total relative top-1 transition-all duration-300 ease-in-out">
              <div>
                  <h1 class="pageTitle text-4xl md:text-6xl mt-4 text-gray-800 dark:text-white">
                      Criar Nota para a Avaliação #{{ $evaluation->evaluation_number }}
                  </h1>
                  <h2 class="text-4xl mt-2 text-gray-700 dark:text-gray-300 text-center font-londrina">Aluno: {{ $student->name }}</h2>
              </div>
      
              @if ($errors->any())
                  <div class="alert alert-danger mt-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
      
              <div class="container mx-auto p-4 py-8">
                  <form action="{{ route('teachers.grades.update', $evaluation->evaluation_id) }}" method="POST" class="space-y-4">
                      @csrf
                      <input type="hidden" name="entity_id" value="{{ Auth::user()->entity_id }}">
                      <input type="hidden" name="teacher_user_id" value="{{ Auth::id() }}">
                      <input type="hidden" name="student_user_id" value="{{ $student_user_id }}">
                      <input type="hidden" name="class_id" value="{{ $classId }}">
                      <input type="hidden" name="evaluation_id" value="{{ $evaluation->evaluation_id }}">
      
                      <div class="overflow-x-auto bg-white p-4 rounded-lg shadow-md dark:bg-gray-700 mt-6">
                          <table class="w-full text-left">
                              <thead class="bg-gradient-to-r from-blue-500 to-blue-400 text-white border-b-2 border-gray-300 dark:border-gray-600">
                                  <tr>
                                      <th class="p-2">Disciplina</th>
                                      <th class="p-2">Conteúdo Programático</th>
                                      <th class="p-2">Conceitos</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach ($classSyllabus as $syllabus)
                                      <tr class="border-b border-gray-300 dark:border-gray-600">
                                          <td class="p-2 text-gray-700 dark:text-gray-300">
                                              @if ($loop->first || $classSyllabus[$loop->index - 1]->class_subject_id !== $syllabus->class_subject_id)
                                                  {{ $syllabus->class_subject_name }}
                                              @else
                                                  <!-- Leave empty for subsequent rows of the same subject -->
                                              @endif
                                          </td>
                                          <td class="p-2 text-gray-700 dark:text-gray-300">{{ $syllabus->class_syllabus_name }}</td>
                                          <td class="p-2">
                                              @foreach ($concepts as $concept)
                                                  <label class="block">
                                                      <input type="radio" name="concepts[{{ $syllabus->class_syllabus_id }}]"
                                                             value="{{ $concept->concept_id }}"
                                                             @if($syllabus->concept_id == $concept->concept_id) checked @endif
                                                             class="mr-2">
                                                      {{ $concept->concept_name }}
                                                  </label>
                                              @endforeach
                                          </td>
                                      </tr>
                                  @endforeach
                              </tbody>
                          </table>
                      </div>
      
                      <div class="flex justify-center mt-6">
                          <button type="submit" class="blueButton rounded-xl sm:w-[50%] md:w-[35%] lg:w-[30%] py-3 text-white font-bold text-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                              Adicionar Nota
                          </button>
                      </div>
                  </form>
              </div>
          </div>
      </main>
      




    {{-- <a href="{{ route('teachers.grades.table', $classId) }}">Back</a><br><br>
    <h1>Create Grade for Evaluation #{{ $evaluation->evaluation_number }}</h1>
    <h2>Student: {{ $student->name }}</h2>





    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('teachers.grades.update', $evaluation->evaluation_id) }}" method="POST">
        @csrf
        <input type="hidden" name="entity_id" value="{{ Auth::user()->entity_id }}">
        <input type="hidden" name="teacher_user_id" value="{{ Auth::id() }}">
        <input type="hidden" name="student_user_id" value="{{ $student_user_id }}">
        <input type="hidden" name="class_id" value="{{ $classId }}">
        <input type="hidden" name="evaluation_id" value="{{ $evaluation->evaluation_id }}">

        <table>
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Syllabus</th>
                    <th>Concepts</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($classSyllabus as $syllabus)
                    <tr>
                        <td>
                            @if ($loop->first || $classSyllabus[$loop->index - 1]->class_subject_id !== $syllabus->class_subject_id)
                                {{ $syllabus->class_subject_name }}
                            @else
                                <!-- Leave empty for subsequent rows of the same subject -->
                            @endif
                        </td>
                        <td>
                            {{ $syllabus->class_syllabus_name }}
                        </td>
                        <td>
                            @foreach ($concepts as $concept)
                                <label>
                                    <input type="radio" name="concepts[{{ $syllabus->class_syllabus_id }}]"
                                           value="{{ $concept->concept_id }}"
                                           @if($syllabus->concept_id == $concept->concept_id) checked @endif>
                                    {{ $concept->concept_name }}
                                </label>
                                <br>
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit">Add Grade</button>
    </form> --}}
</x-layout>