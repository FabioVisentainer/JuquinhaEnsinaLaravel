<div class="form-group mb-4">
    <div class="text-red-600 text-xl font-londrina p-2 rounded-lg">
        <x-errors/>
    </div>

    <!-- Verifica se $syllabus está definido para determinar se estamos editando ou criando -->
    @if(isset($syllabus))
        <!-- Se estiver editando, mostra o nome como valor no input -->
        <label for="class_syllabus_name" class="block text-lg font-semibold dark:text-gray-200">Nome do Conteúdo</label>
        <input type="text" name="class_syllabus_name" id="class_syllabus_name" value="{{ $syllabus->class_syllabus_name }}" required autocomplete="off" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
    @else
        <!-- Se estiver criando um novo conteúdo -->
        <label for="class_syllabus_name" class="block text-lg font-semibold dark:text-gray-200">Nome do Conteúdo</label>
        <input type="text" name="class_syllabus_name" id="class_syllabus_name" value="{{ old('class_syllabus_name') }}" required autocomplete="off" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
    @endif
</div>

<div class="form-group mb-4">
    <!-- Descrição do Conteúdo -->
    <label for="class_syllabus_description" class="block text-lg font-semibold dark:text-gray-200">Descrição do Conteúdo</label>
    <textarea name="class_syllabus_description" id="class_syllabus_description" required class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">{{ old('class_syllabus_description', $syllabus->class_syllabus_description ?? '') }}</textarea>
</div>

<!-- Seleção de entidade, oculto ou preenchido automaticamente se não for necessário -->
<input type="hidden" name="entity_id" value="{{ $syllabus->entity_id ?? old('entity_id', $entityId ?? '') }}">

<!-- Seleção do ID da disciplina, oculto ou preenchido automaticamente se não for necessário -->
<input type="hidden" name="class_subject_id" value="{{ $classSubject->class_subject_id ?? old('class_subject_id', $classSubjectId ?? '') }}">

<div class="form-group mb-4">
    <!-- Checkbox de Ativo -->
    <label for="is_active" class="block text-lg font-semibold dark:text-gray-200">Está Ativo?</label>
    <input type="hidden" name="is_active" value="0"> <!-- Garante que '0' seja enviado quando não marcado -->
    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $syllabus->is_active ?? true) ? 'checked' : '' }} class="rounded border-gray-300 dark:border-gray-600 dark:text-white text-blue-600 focus:ring-blue-500">
</div>
