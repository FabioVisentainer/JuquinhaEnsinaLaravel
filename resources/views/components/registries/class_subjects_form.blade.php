<div class="space-y-4">
    
    <div class="text-red-600 text-xl font-londrina p-2 border-red-200 rounded-lg">
        <x-errors/>
    </div>

    @if (isset($classSubject))
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

    <input 
        type="hidden" 
        name="entity_id" 
        value="{{ $classSubject->entity_id ?? old('entity_id', $entityId ?? '') }}"
    >

    <div class="flex items-center">
        <input 
            type="hidden" 
            name="is_active" 
            value="0"
        >
        <input 
            type="checkbox" 
            name="is_active" 
            value="1" 
            {{ old('is_active', $classSubject->is_active ?? true) ? 'checked' : '' }} 
            class="rounded border-gray-300 dark:border-gray-700 text-blue-600 focus:ring-blue-500 mr-1"
        >
        <label for="is_active" class="label font-semibold text-gray-700 dark:text-gray-300">Está ativa?</label>
    </div>
</div>
