<div>
    <!-- Check if $class is set to determine if we're editing or creating -->
    @if(isset($class))
        <!-- If editing, show the name as a value in the input -->
        <label for="class_name">Class Name</label>
        <input type="text" name="class_name" id="class_name" value="{{ $class->class_name }}" required autocomplete="off">

        <label for="class_year">Class Year</label>
        <input type="number" name="class_year" id="class_year" value="{{ $class->class_year }}" required min="2000" max="2100" step="1">
    @else
        <!-- If creating a new class -->
        <label for="class_name">Class Name</label>
        <input type="text" name="class_name" id="class_name" value="{{ old('class_name') }}" required autocomplete="off">

        <label for="class_year">Class Year</label>
        <input type="number" name="class_year" id="class_year" value="{{ old('class_year') }}" required min="2000" max="2100" step="1">
    @endif

    <!-- Entity selection, hidden or auto-filled if not needed -->
    <input type="hidden" name="entity_id" value="{{ old('entity_id', Auth::user()->entity_id) }}">

    <!-- Include error messages -->
    <x-errors />
</div>