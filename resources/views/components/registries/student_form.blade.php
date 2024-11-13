@php
use Illuminate\Support\Facades\DB;

$specialNeeds = DB::table('tb_special_needs')->get(); // Fetch special needs directly from the database
@endphp

@csrf

{{-- <!-- Special Need -->
<label for="special_need_id">Special Need</label>
<select name="special_need_id" id="special_need_id" required autocomplete="off">
    <option value="">Select a Special Need</option> <!-- Default option -->
    @foreach($specialNeeds as $specialNeed)
        <option value="{{ $specialNeed->special_need_id }}" {{ old('special_need_id', $student->special_need_id ?? '') == $specialNeed->special_need_id ? 'selected' : '' }}>
            {{ $specialNeed->special_need_name }}
        </option>
    @endforeach
</select>

<!-- Full Name -->
<label for="student_name">Full Name</label>
<input type="text" name="student_name" id="student_name" value="{{ old('student_name', $student->student_name ?? '') }}" required autocomplete="off">

<!-- Gender -->
<label for="student_gender">Gender</label>
<div>
    <input type="radio" name="student_gender" value="masculine" id="gender_masculine" {{ old('student_gender', $student->student_gender ?? '') == 'masculine' ? 'checked' : '' }} autocomplete="off">
    <label for="gender_masculine">Masculine</label>
</div>
<div>
    <input type="radio" name="student_gender" value="feminine" id="gender_feminine" {{ old('student_gender', $student->student_gender ?? '') == 'feminine' ? 'checked' : '' }} autocomplete="off">
    <label for="gender_feminine">Feminine</label>
</div>

<!-- Birth Date -->
<label for="student_birth_date">Birth Date</label>
<input type="date" name="student_birth_date" id="student_birth_date" value="{{ old('student_birth_date', $student->student_birth_date ?? '') }}" required autocomplete="off">

<!-- CPF Number -->
<label for="student_cpf_number">CPF Number</label>
<input type="text" name="student_cpf_number" id="student_cpf_number" value="{{ old('student_cpf_number', $student->student_cpf_number ?? '') }}" maxlength="11" required autocomplete="off">

<!-- Registry Date -->
<label for="student_registry_date">Registry Date</label>
<input type="date" name="student_registry_date" id="student_registry_date" value="{{ old('student_registry_date', $student->student_registry_date ?? '') }}" required autocomplete="off">

<!-- is_active Checkbox -->
<label for="is_active">Is Active?</label>
<input type="hidden" name="is_active" value="0"> <!-- This ensures '0' is sent when unchecked -->
<input type="checkbox" name="is_active" value="1" {{ old('is_active', $student->is_active ?? true) ? 'checked' : '' }}>
<br>

<!-- Password (shown for create, optional on edit) -->
@if (!isset($student))
    <label for="password">Password</label>
    <input type="password" name="password" id="password" required autocomplete="off">
@else
    <label for="password">Change Password (leave blank to keep current)</label>
    <input type="password" name="password" id="password" autocomplete="off">
@endif

<!-- Show Username when editing -->
@if (isset($student) && isset($student->user))
    <label for="username">Username</label>
    <input type="text" name="username" id="username" value="{{ $student->user->username }}" readonly>
@endif
 --}}
<!-- Show Username when editing -->
@if (isset($student) && isset($student->user))
    <label for="username" class="label">Usuário para login</label>
    <input type="text" name="username" id="username" value="{{ $student->user->username }}" readonly class="inputBox bg-zinc-100 dark:bg-slate-100">
@endif

<!-- Password -->
@if (!isset($student))
    <label for="password" class="label">Senha</label>
    <input type="password" name="password" id="password" placeholder="senha" required autocomplete="off" class="inputBox bg-zinc-100 dark:bg-slate-100">
@else
    <label for="password" class="label">Mude a Senha </label>
    <input type="password" name="password" value="Deixe em branco para utilizar a mesma..." id="password" autocomplete="off" class="inputBox bg-zinc-100 dark:bg-slate-100">
@endif

<!-- Special Need -->
<label for="special_need_id" class="label">Necessidade Especial</label>
<select name="special_need_id" id="special_need_id" required autocomplete="off" class="inputBox bg-zinc-100 dark:bg-slate-100">
    <option value="">Select a Special Need</option>
    @foreach($specialNeeds as $specialNeed)
        <option value="{{ $specialNeed->special_need_id }}" {{ old('special_need_id', $student->special_need_id ?? '') == $specialNeed->special_need_id ? 'selected' : '' }}>
            {{ $specialNeed->special_need_name }}
        </option>
    @endforeach
</select>

<!-- Full Name -->
<label for="student_name" class="label">Nome Completo</label>
<input type="text" name="student_name" id="student_name" placeholder="nome" value="{{ old('student_name', $student->student_name ?? '') }}" required autocomplete="off" class="inputBox bg-zinc-100 dark:bg-slate-100">

<!-- Gender -->
<label for="student_gender" class="label">Genero</label>
<div class="flex items-center gap-2 w-full ml-24">
    <label for="gender_masculine" class="invertColor font-londrina">Masculino</label>
    <input type="radio" name="student_gender" value="masculine" id="gender_masculine" {{ old('student_gender', $student->student_gender ?? '') == 'masculine' ? 'checked' : '' }} autocomplete="off">
</div>
<div class="flex items-center gap-2 w-full ml-24">
    <label for="gender_feminine" class="invertColor font-londrina">Feminino</label>
    <input type="radio" name="student_gender" value="feminine" id="gender_feminine" {{ old('student_gender', $student->student_gender ?? '') == 'feminine' ? 'checked' : '' }} autocomplete="off">
</div>

<!-- Birth Date -->
<label for="student_birth_date" class="label">Data de Nascimento</label>
<input type="date" name="student_birth_date" id="student_birth_date" value="{{ old('student_birth_date', $student->student_birth_date ?? '') }}" required autocomplete="off" class="inputBox bg-zinc-100 dark:bg-slate-100">

<!-- CPF Number -->
<label for="student_cpf_number" class="label">Cpf <span class="font-londrina text-sm text-black dark:text-white"> *Apenas numeros</span></label>
<input type="text" name="student_cpf_number" id="student_cpf_number" placeholder="00000000000" value="{{ old('student_cpf_number', $student->student_cpf_number ?? '') }}" maxlength="11" required autocomplete="off" class="inputBox bg-zinc-100 dark:bg-slate-100">

<!-- Registry Date -->
<label for="student_registry_date" class="label">Data de Registro</label>
<input type="date" name="student_registry_date" id="student_registry_date" value="{{ old('student_registry_date', $student->student_registry_date ?? '') }}" required autocomplete="off" class="inputBox bg-zinc-100 dark:bg-slate-100">

<!-- is_active Checkbox -->
<div class="flex items-center gap-2 w-full ml-4">
    <label for="is_active" class="invertColor font-londrina">Está ativo?</label>
    <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $student->is_active ?? true) ? 'checked' : '' }} class="ml-4">
</div>
