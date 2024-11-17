<div>
    <div class="form-group mb-4">
        
        <div class="text-red-600 text-xl font-londrina p-2 rounded-lg">
            <x-errors/>
        </div>

        <label for="chronogram_name" class="block text-lg font-semibold dark:text-gray-200">Nome do Cronograma</label>
        @if(isset($chronogram))
            <input type="text" name="chronogram_name" id="chronogram_name" value="{{ $chronogram->chronogram_name }}" required autocomplete="off" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        @else
            <input type="text" name="chronogram_name" id="chronogram_name" value="{{ old('chronogram_name') }}" required autocomplete="off" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        @endif
    </div>
    
    <input type="hidden" name="entity_id" value="{{ old('entity_id', Auth::user()->entity_id) }}">
    
    <div class="form-group mb-4">
        <label for="is_active" class="block text-lg font-semibold dark:text-gray-200">Está Ativo?</label>
        <input type="hidden" name="is_active" value="0">
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $chronogram->is_active ?? true) ? 'checked' : '' }} class="rounded border-gray-300 dark:border-gray-600 dark:text-white text-blue-600 focus:ring-blue-500">
    </div>
</div>
