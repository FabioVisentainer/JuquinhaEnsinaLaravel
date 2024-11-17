<div> 
    <div class="text-red-600 text-xl font-londrina p-2 rounded-lg">
        <x-errors/>
    </div>

    @if(isset($teacher))
        <!-- Display username as read-only -->
        <label for="usuario" class="label">Usuário para login</label> 
        <input type="text" name="username" id="username" value="{{ $teacher->user->username }}" placeholder="usuario" required autocomplete="off" readonly class="inputBox bg-zinc-100 dark:bg-slate-100">
    @else
        <label for="usuario" class="label hidden">Usuário para login</label>
        <input type="text" name="username" id="username" value="{{ old('username') }}" placeholder="usuario" readonly required autocomplete="off" class="inputBox bg-zinc-100 dark:bg-slate-100 hidden">
    @endif

    <label for="usuario" class="label">Senha</label> 
    <input type="password" name="password" id="password" autocomplete="off" placeholder="Deixar Branco para manter senha" class="inputBox bg-zinc-100 dark:bg-slate-100">

    <label for="usuario" class="label">Numero de Contato <span class="pl-2 font-londrina text-sm text-black dark:text-white"> *Apenas numeros</span></label> 
    <input type="text" name="teacher_contact_number" id="teacher_contact_number" value="{{ $teacher->teacher_contact_number ?? old('teacher_contact_number') }}" required autocomplete="off" class="inputBox bg-zinc-100 dark:bg-slate-100">

    <label for="usuario" class="label">Email de Contato</label> 
    <input type="email" name="teacher_contact_mail" id="teacher_contact_mail" placeholder="exemplo@gmail.com" value="{{ $teacher->teacher_contact_mail ?? old('teacher_contact_mail') }}" required autocomplete="off" class="inputBox bg-zinc-100 dark:bg-slate-100">

    <label for="usuario" class="label">Nome Completo</label> 
    <input type="text" name="teacher_name" id="teacher_name" placeholder="nome" value="{{ $teacher->teacher_name ?? old('teacher_name') }}" required autocomplete="off" class="inputBox bg-zinc-100 dark:bg-slate-100">

    <label for="usuario" class="label">Numero de Cpf<span class="pl-2 font-londrina text-sm text-black dark:text-white">*Apenas numeros</span></label> 
    <input type="text" name="teacher_cpf_number" id="teacher_cpf_number" placeholder="00000000000" value="{{ $teacher->teacher_cpf_number ?? old('teacher_cpf_number') }}" maxlength="11" required autocomplete="off" class="inputBox bg-zinc-100 dark:bg-slate-100">

    <label for="usuario" class="label">Data de nascimento</label> 
    <input type="date" name="teacher_birth_date" id="teacher_birth_date" value="{{ $teacher->teacher_birth_date ?? old('teacher_birth_date') }}" required autocomplete="off" class="inputBox bg-zinc-100 dark:bg-slate-100">
    
    <label for="teacher_registry_date" class="label">Data de Registro</label>
    <input type="date" name="teacher_registry_date" id="teacher_registry_date" value="{{ $teacher->teacher_registry_date ?? old('teacher_registry_date') }}" required autocomplete="off" class="inputBox bg-zinc-100 dark:bg-slate-100">

    <label for="usuario" class="label">Rua</label> 
    <input type="text" name="adress_street_name" id="adress_street_name" value="{{ $teacher->address->adress_street_name ?? old('adress_street_name') }}" required autocomplete="off" class="inputBox bg-zinc-100 dark:bg-slate-100">

    <label for="usuario" class="label">Numero de endereco</label> 
    <input type="text" name="adress_number" id="adress_number" value="{{ $teacher->address->adress_number ?? old('adress_number') }}" required autocomplete="off" class="inputBox bg-zinc-100 dark:bg-slate-100">

    <label for="usuario" class="label">CEP <span class="font-londrina text-sm text-black dark:text-white"> *Apenas numeros</span></label> 
    <input type="text" name="cep_code" id="cep_code" maxlength="8" placeholder="00000000" value="{{ $tutor->address->cep_code ?? old('cep_code') }}" required autocomplete="off" class="inputBox bg-zinc-100 dark:bg-slate-100">

    <input type="button" value="Encontrar Endereço" id="fetchAddressBtn" class="blueButton rounded-md w-full">

    <label for="usuario" class="label">Cidade</label> 
    <input name="city_id" id="city_id" value="{{ $teacher->address->city->name ?? '' }}" class="inputBox bg-gray-300 border-gray-300" disabled="disabled">

    <label for="usuario" class="label">Estado</label> 
    <input name="state_id" id="state_id" value="{{ $teacher->address->state->name ?? '' }}" class="inputBox bg-gray-300 border-gray-300" disabled="disabled">

    <label for="usuario" class="label">Pais</label> 
    <input name="country_id" id="country_id" value="{{ $teacher->address->country->name ?? '' }}" class="inputBox bg-gray-300 border-gray-300" disabled="disabled">

    <div class="flex items-center gap-2 w-full ml-4">
        <label for="is_active" class="invertColor font-londrina">Está ativo?</label>
        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $teacher->is_active ?? true) ? 'checked' : '' }} class="ml-4">
    </div>

    <div class="flex items-center gap-2 w-full ml-4">
        <label for="is_active" class="invertColor font-londrina">Coordenador?</label>
        <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('coordinator', $teacher->coordinator ?? false) ? 'checked' : '' }} class="ml-4">
    </div>

    <script>
        document.getElementById('fetchAddressBtn').addEventListener('click', function() {
            const cep = document.getElementById('cep_code').value;
    
            fetch(`/cep/${cep}`)
                .then(response => response.json())
                .then(data => {
                    if (data.city) {
                        // Assign the city, state, and country names to the input fields
                        document.getElementById('city_id').value = data.city.name;
                        document.getElementById('state_id').value = data.state.name;
                        document.getElementById('country_id').value = data.country.name;
    
                        // Display the updated values if necessary
                        document.getElementById('cityDisplay').innerText = data.city.name;
                        document.getElementById('stateDisplay').innerText = data.state.name;
                        document.getElementById('countryDisplay').innerText = data.country.name;
    
                        document.getElementById('addressDisplay').style.display = 'block';
                    }
                });
        });
    </script>
</div>
