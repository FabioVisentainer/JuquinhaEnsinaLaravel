<div>
    <!-- Check if $class is set to determine if we're editing or creating -->
    {{-- @if(isset($class))
        <!-- If editing, show the name as a value in the input -->
        <label for="class_name">Class Name</label>
        <input type="text" name="class_name" id="class_name" value="{{ $class->class_name }}" required autocomplete="off">

        <label for="class_year">Class Year</label>
        <input type="number" name="class_year" id="class_year" value="{{ $class->class_year }}" required min="2000" max="2100" step="1">
    @else
        <!-- If creating a new class -->
        <label for="class_name">Class Name</label>
        <input type="text" name="class_name" id="class_name" value="{{ old('class_name') }}" required autocomplete="off">

        <label for="class_year">Class Year</label>
        <input type="number" name="class_year" id="class_year" value="{{ old('class_year') }}" required min="2000" max="2100" step="1">
    @endif

    <!-- Entity selection, hidden or auto-filled if not needed -->
    <input type="hidden" name="entity_id" value="{{ old('entity_id', Auth::user()->entity_id) }}"> --}}
        
    <div class="text-black text-xl bg-red-100 font-londrina p-2 border-red-200 rounded-lg">
                      <x-errors/>
                    </div>

        @if (isset($class))
            <!-- Se estiver editando, mostra o nome da turma como valor no input -->
            <label for="class_name" class="label">Nome da Turma</label>
            <input type="text" name="class_name" id="class_name" value="{{ $class->class_name }}" required autocomplete="off" class="inputBox bg-zinc-100 dark:bg-slate-100">
    
            <label for="class_year" class="label">Ano da Turma</label>
            <input type="number" name="class_year" id="class_year" value="{{ $class->class_year }}" required min="2000" max="2100" step="1" class="inputBox bg-zinc-100 dark:bg-slate-100">
        @else
            <!-- Se estiver criando uma nova turma -->
            <label for="class_name" class="label">Nome da Turma</label>
            <input type="text" name="class_name" id="class_name" value="{{ old('class_name') }}" required autocomplete="off" class="inputBox bg-zinc-100 dark:bg-slate-100">
    
            <label for="class_year" class="label">Ano da Turma</label>
            <input type="number" name="class_year" id="class_year" value="{{ old('class_year') }}" required min="2000" max="2100" step="1" class="inputBox bg-zinc-100 dark:bg-slate-100">
        @endif
    
        <!-- Seleção de entidade, oculta ou preenchida automaticamente se não for necessária -->
        <input type="hidden" name="entity_id" value="{{ old('entity_id', Auth::user()->entity_id) }}">
    
    <!-- Include error messages -->
    <x-errors />
</div>