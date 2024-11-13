<div class="space-y-4">
    
<div class="text-black text-xl bg-red-100 font-londrina p-2 border-red-200 rounded-lg">
                      <x-errors/>
                    </div>

    <!-- Verificação para edição ou criação -->
    @if(isset($classSubject))
        <!-- Se for edição, mostra o nome como valor no input -->
        <label for="class_subject_name" class="label font-semibold text-gray-700 dark:text-gray-300">Nome da disciplina</label>
        <input 
            type="text" 
            name="class_subject_name" 
            id="class_subject_name" 
            value="{{ $classSubject->class_subject_name }}" 
            required 
            autocomplete="off" 
            class="inputBox bg-zinc-100 dark:bg-slate-100 p-2 rounded border border-gray-300 dark:border-gray-700"
        >
    @else
        <!-- Se for criação de uma nova disciplina -->
        <label for="class_subject_name" class="label font-semibold text-gray-700 dark:text-gray-300">Nome da disciplina</label>
        <input 
            type="text" 
            name="class_subject_name" 
            id="class_subject_name" 
            value="{{ old('class_subject_name') }}" 
            required 
            autocomplete="off" 
            class="inputBox bg-zinc-100 dark:bg-slate-100 p-2 rounded border border-gray-300 dark:border-gray-700"
        >
    @endif

    <!-- Seleção de entidade, oculta ou preenchida automaticamente se não for necessário -->
    <input 
        type="hidden" 
        name="entity_id" 
        value="{{ $classSubject->entity_id ?? old('entity_id', $entityId ?? '') }}"
    >

    <!-- Checkbox de Ativação -->
    <div class="flex items-center">
        <input 
            type="hidden" 
            name="is_active" 
            value="0"
        > <!-- Garante que '0' é enviado quando desmarcado -->
        <input 
            type="checkbox" 
            name="is_active" 
            value="1" 
            {{ old('is_active', $classSubject->is_active ?? true) ? 'checked' : '' }} 
            class="rounded border-gray-300 dark:border-gray-700 text-blue-600 focus:ring-blue-500 mr-1"
        >
        <label for="is_active" class="label font-semibold text-gray-700 dark:text-gray-300">Esta ativa?</label>
    </div>
</div>



{{-- <div>
    <!-- Check if $classSubject is set to determine if we're editing or creating -->
    @if(isset($classSubject))
        <!-- If editing, show the name as a value in the input -->
        <label for="class_subject_name">Class Subject Name</label>
        <input type="text" name="class_subject_name" id="class_subject_name" value="{{ $classSubject->class_subject_name }}" required autocomplete="off">
    @else
        <!-- If creating a new subject -->
        <label for="class_subject_name">Class Subject Name</label>
        <input type="text" name="class_subject_name" id="class_subject_name" value="{{ old('class_subject_name') }}" required autocomplete="off">
    @endif

    <!-- Entity selection, hidden or auto-filled if not needed -->
    <input type="hidden" name="entity_id" value="{{ $classSubject->entity_id ?? old('entity_id', $entityId ?? '') }}">

    <!-- is_active Checkbox -->
    <label for="is_active">Is Active?</label>
    <input type="hidden" name="is_active" value="0"> <!-- This ensures '0' is sent when unchecked -->
    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $classSubject->is_active ?? true) ? 'checked' : '' }}>

    <!-- Submit button will be provided in the parent form -->
</div> --}}

<!-- Include error messages -->

