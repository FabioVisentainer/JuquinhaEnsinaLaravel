<div>
    <div class="text-red-600 text-xl font-londrina p-2 rounded-lg">
        <x-errors/>
    </div>

    @if (isset($class))
        <label for="class_name" class="label">Nome da Turma</label>
        <input type="text" name="class_name" id="class_name" value="{{ $class->class_name }}" required autocomplete="off" class="inputBox bg-zinc-100 dark:bg-slate-100">
    
        <label for="class_year" class="label">Ano da Turma</label>
        <input type="number" name="class_year" id="class_year" value="{{ $class->class_year }}" required min="2000" max="2100" step="1" class="inputBox bg-zinc-100 dark:bg-slate-100">
    @else
        <label for="class_name" class="label">Nome da Turma</label>
        <input type="text" name="class_name" id="class_name" value="{{ old('class_name') }}" required autocomplete="off" class="inputBox bg-zinc-100 dark:bg-slate-100">
    
        <label for="class_year" class="label">Ano da Turma</label>
        <input type="number" name="class_year" id="class_year" value="{{ old('class_year') }}" required min="2000" max="2100" step="1" class="inputBox bg-zinc-100 dark:bg-slate-100">
    @endif

    <input type="hidden" name="entity_id" value="{{ old('entity_id', Auth::user()->entity_id) }}">
</div>
