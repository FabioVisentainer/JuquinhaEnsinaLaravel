<div>
    
    {{-- <!-- Check if $chronogram is set to determine if we're editing or creating -->
    @if(isset($chronogram))
        <!-- If editing, show the name as a value in the input -->
        <label for="chronogram_name">Chronogram Name</label>
        <input type="text" name="chronogram_name" id="chronogram_name" value="{{ $chronogram->chronogram_name }}" required autocomplete="off">
    @else
        <!-- If creating a new chronogram -->
        <label for="chronogram_name">Chronogram Name</label>
        <input type="text" name="chronogram_name" id="chronogram_name" value="{{ old('chronogram_name') }}" required autocomplete="off">
    @endif

    <!-- Entity selection, hidden or auto-filled if not needed -->
    <input type="hidden" name="entity_id" value="{{ old('entity_id', Auth::user()->entity_id) }}">

    <!-- is_active Checkbox -->
    <label for="is_active">Is Active?</label>
    <input type="hidden" name="is_active" value="0"> <!-- This ensures '0' is sent when unchecked -->
    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $chronogram->is_active ?? true) ? 'checked' : '' }}> --}}
    <div class="form-group mb-4">
        
    <div class="text-black text-xl bg-red-100 font-londrina p-2 border-red-200 rounded-lg">
                      <x-errors/>
                    </div>

        <!-- Check if $chronogram is set to determine if we're editing or creating -->
        @if(isset($chronogram))
            <!-- If editing, show the name as a value in the input -->
            <label for="chronogram_name" class="block text-lg font-semibold dark:text-gray-200">Nome do Cronograma</label>
            <input type="text" name="chronogram_name" id="chronogram_name" value="{{ $chronogram->chronogram_name }}" required autocomplete="off" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        @else
            <!-- If creating a new chronogram -->
            <label for="chronogram_name" class="block text-lg font-semibold dark:text-gray-200">Nome do Cronograma</label>
            <input type="text" name="chronogram_name" id="chronogram_name" value="{{ old('chronogram_name') }}" required autocomplete="off" class="w-full p-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white">
        @endif
    </div>
    
    <!-- Entity selection, hidden or auto-filled if not needed -->
    <input type="hidden" name="entity_id" value="{{ old('entity_id', Auth::user()->entity_id) }}">
    
    <div class="form-group mb-4">
        <!-- is_active Checkbox -->
        <label for="is_active" class="block text-lg font-semibold dark:text-gray-200">Está Ativo?</label>
        <input type="hidden" name="is_active" value="0"> <!-- This ensures '0' is sent when unchecked -->
        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $chronogram->is_active ?? true) ? 'checked' : '' }} class="rounded border-gray-300 dark:border-gray-600 dark:text-white text-blue-600 focus:ring-blue-500">
    </div>
    

    <!-- Include error messages -->
</div>