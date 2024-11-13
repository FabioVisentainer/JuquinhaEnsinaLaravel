
<div class="form-group mb-4">
    
<div class="text-black text-xl bg-red-100 font-londrina p-2 border-red-200 rounded-lg">
                      <x-errors/>
                    </div>

    <!-- Check if $syllabus is set to determine if we're editing or creating -->
    @if(isset($syllabus))
        <!-- If editing, show the name as a value in the input -->
        <label for="class_syllabus_name" class="block text-lg font-semibold dark:text-gray-200">Nome do Conteudo</label>
        <input type="text" name="class_syllabus_name" id="class_syllabus_name" value="{{ $syllabus->class_syllabus_name }}" required autocomplete="off" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
    @else
        <!-- If creating a new syllabus -->
        <label for="class_syllabus_name" class="block text-lg font-semibold dark:text-gray-200">Nome do Conteudo</label>
        <input type="text" name="class_syllabus_name" id="class_syllabus_name" value="{{ old('class_syllabus_name') }}" required autocomplete="off" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
    @endif
</div>

<div class="form-group mb-4">
    <!-- Syllabus Description -->
    <label for="class_syllabus_description" class="block text-lg font-semibold dark:text-gray-200">Descricao do Conteudo</label>
    <textarea name="class_syllabus_description" id="class_syllabus_description" required class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('class_syllabus_description', $syllabus->class_syllabus_description ?? '') }}</textarea>
</div>

<!-- Entity selection, hidden or auto-filled if not needed -->
<input type="hidden" name="entity_id" value="{{ $syllabus->entity_id ?? old('entity_id', $entityId ?? '') }}">

<!-- Class Subject ID selection, hidden or auto-filled if not needed -->
<input type="hidden" name="class_subject_id" value="{{ $classSubject->class_subject_id ?? old('class_subject_id', $classSubjectId ?? '') }}">

<div class="form-group mb-4">
    <!-- is_active Checkbox -->
    <label for="is_active" class="block text-lg font-semibold dark:text-gray-200">Esta Ativo?</label>
    <input type="hidden" name="is_active" value="0"> <!-- This ensures '0' is sent when unchecked -->
    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $syllabus->is_active ?? true) ? 'checked' : '' }} class="rounded border-gray-300 dark:border-gray-600 dark:text-white text-blue-600 focus:ring-blue-500">
</div>

{{-- <div>
    <!-- Check if $syllabus is set to determine if we're editing or creating -->
    @if(isset($syllabus))
        <!-- If editing, show the name as a value in the input -->
        <label for="class_syllabus_name">Syllabus Name</label>
        <input type="text" name="class_syllabus_name" id="class_syllabus_name" value="{{ $syllabus->class_syllabus_name }}" required autocomplete="off">
    @else
        <!-- If creating a new syllabus -->
        <label for="class_syllabus_name">Syllabus Name</label>
        <input type="text" name="class_syllabus_name" id="class_syllabus_name" value="{{ old('class_syllabus_name') }}" required autocomplete="off">
    @endif

    <!-- Syllabus Description -->
    <label for="class_syllabus_description">Syllabus Description</label>
    <textarea name="class_syllabus_description" id="class_syllabus_description" required>{{ old('class_syllabus_description', $syllabus->class_syllabus_description ?? '') }}</textarea>

    <!-- Entity selection, hidden or auto-filled if not needed -->
    <input type="hidden" name="entity_id" value="{{ $syllabus->entity_id ?? old('entity_id', $entityId ?? '') }}">
    
    <!-- Class Subject ID selection, hidden or auto-filled if not needed -->
    <input type="hidden" name="class_subject_id" value="{{ $classSubject->class_subject_id ?? old('class_subject_id', $classSubjectId ?? '') }}">

    <!-- is_active Checkbox -->
    <label for="is_active">Is Active?</label>
    <input type="hidden" name="is_active" value="0"> <!-- This ensures '0' is sent when unchecked -->
    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $syllabus->is_active ?? true) ? 'checked' : '' }}>

    <!-- Submit button will be provided in the parent form -->
</div> --}}

<!-- Include error messages -->
