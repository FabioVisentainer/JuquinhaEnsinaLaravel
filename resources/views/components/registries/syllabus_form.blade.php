<div>
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
</div>

<!-- Include error messages -->
<x-errors />