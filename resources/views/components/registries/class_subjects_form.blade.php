<div>
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
</div>

<!-- Include error messages -->
<x-errors />