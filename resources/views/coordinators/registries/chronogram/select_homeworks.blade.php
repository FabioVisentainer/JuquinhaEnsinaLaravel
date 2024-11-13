<x-layout>
<body class="body bg-slate-50">
        <nav class="flex justify-between items-center">
        <div class="p-5 md:flex md:justify-between max-[770px]:hidden">
          <div class="max-[770px]:hidden">
            <!-- Div do botao de voltar -->
            <a href="{{ route('coordinators.registries.chronograms.edit', $chronogram->chronogram_id) }}"><img class="invertColor cursor-pointer pointer-events-auto" src="{{ asset('images/voltar.png') }}" alt="Botao de voltar a pagina" width="40px"></a>
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


    <h1>Select Homeworks for Chronogram: {{ $chronogram->chronogram_name }}</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('coordinators.save_homeworks', $chronogram->chronogram_id) }}" method="POST">
        @csrf

        <table>
            <thead>
                <tr>
                    <th>Select</th>
                    <th>Homework Name</th>
                    <th>Homework URL</th>
                    <th>Release Date</th>
                    <th>Due Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($homeworks as $homework)
                    @php
                        // Fetch the associated homework from the $associatedHomeworks collection
                        $associatedHomework = $associatedHomeworks->firstWhere('homework_id', $homework->homework_id);
                    @endphp

                    <tr>
                        <td>
                            <input type="checkbox" name="homeworks[]" value="{{ $homework->homework_id }}" 
                                {{ $associatedHomework ? 'checked' : '' }}
                                onchange="toggleDateFields({{ $homework->homework_id }})">
                        </td>
                        <td>{{ $homework->homework_name }}</td>
                        <td>{{ $homework->homework_url }}</td>
                        <td>
                            <input type="datetime-local" id="release_date_{{ $homework->homework_id }}" 
                                name="release_dates[{{ $homework->homework_id }}]" 
                                value="{{ $associatedHomework ? \Carbon\Carbon::parse($associatedHomework->pivot->release_date)->format('Y-m-d\TH:i') : '' }}"
                                {{ $associatedHomework ? '' : 'disabled' }}>
                        </td>
                        <td>
                            <input type="datetime-local" id="due_date_{{ $homework->homework_id }}" 
                                name="due_dates[{{ $homework->homework_id }}]" 
                                value="{{ $associatedHomework ? \Carbon\Carbon::parse($associatedHomework->pivot->due_date)->format('Y-m-d\TH:i') : '' }}"
                                {{ $associatedHomework ? '' : 'disabled' }}>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit">Update Homework Associations</button>
    </form>

    <a href="{{ route('coordinators.registries.chronograms.edit', $chronogram->chronogram_id) }}">Back to Edit Chronogram</a>

    <script>
        function toggleDateFields(homeworkId) {
            const checkbox = document.querySelector(`input[name="homeworks[]"][value="${homeworkId}"]`);
            const releaseDateField = document.getElementById(`release_date_${homeworkId}`);
            const dueDateField = document.getElementById(`due_date_${homeworkId}`);

            // Enable or disable date fields based on checkbox state
            releaseDateField.disabled = !checkbox.checked;
            dueDateField.disabled = !checkbox.checked;
        }
    </script>
</x-layout>