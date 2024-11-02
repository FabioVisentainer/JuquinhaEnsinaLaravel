<div>
    <!-- Check if $chronogram is set to determine if we're editing or creating -->
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
    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $chronogram->is_active ?? true) ? 'checked' : '' }}>

    <!-- Include error messages -->
    <x-errors />
</div>