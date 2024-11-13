<div>
    <!-- Check if $tutor is set to determine if we're editing or creating -->
    {{-- @if(isset($tutor))
        <!-- Display username as read-only -->
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="{{ $tutor->user->username }}" required autocomplete="off" readonly>
    @else
        <input type="hidden" name="username" value="{{ old('username') }}">
    @endif --}}

    <!-- Address Fields -->
    {{-- <label for="cep_code">CEP Code</label>
    <input type="text" name="cep_code" id="cep_code" maxlength="8" value="{{ $tutor->address->cep_code ?? old('cep_code') }}" required autocomplete="off"> --}}

    {{-- <label for="adress_street_name">Street Name</label>
    <input type="text" name="adress_street_name" id="adress_street_name" value="{{ $tutor->address->adress_street_name ?? old('adress_street_name') }}" required autocomplete="off">

    <label for="adress_number">Address Number</label>
    <input type="text" name="adress_number" id="adress_number" value="{{ $tutor->address->adress_number ?? old('adress_number') }}" required autocomplete="off">

    <button type="button" id="fetchAddressBtn">Fetch Address</button> --}}

    <!-- Hidden Fields to Lock City, State, and Country -->
    <input type="hidden" name="city_id" id="city_id" value="{{ $tutor->address->city_id ?? '' }}">
    <input type="hidden" name="state_id" id="state_id" value="{{ $tutor->address->state_id ?? '' }}">
    <input type="hidden" name="country_id" id="country_id" value="{{ $tutor->address->country_id ?? '' }}">

    <!-- City, State, and Country Display -->
    {{-- <div id="addressDisplay" style="display: {{ isset($tutor) ? 'block' : 'none' }};">
        <p>City: <span id="cityDisplay">{{ $tutor->address->city->name ?? '' }}</span></p>
        <p>State: <span id="stateDisplay">{{ $tutor->address->state->name ?? '' }}</span></p>
        <p>Country: <span id="countryDisplay">{{ $tutor->address->country->name ?? '' }}</span></p>
    </div>

    <!-- Tutor Name -->
    <br> --}}
    {{-- <label for="tutor_name">Tutor Name</label>
    <input type="text" name="tutor_name" id="tutor_name" value="{{ $tutor->tutor_name ?? old('tutor_name') }}" required autocomplete="off"> --}}

    <!-- Other Tutor Fields -->
    {{-- <label for="tutor_birth_date">Birth Date</label>
    <input type="date" name="tutor_birth_date" id="tutor_birth_date" value="{{ $tutor->tutor_birth_date ?? old('tutor_birth_date') }}" required autocomplete="off"> --}}

    {{-- <label for="tutor_cpf_number">CPF Number</label>
    <input type="text" name="tutor_cpf_number" id="tutor_cpf_number" value="{{ $tutor->tutor_cpf_number ?? old('tutor_cpf_number') }}" maxlength="11" required autocomplete="off"> --}}

    {{-- <label for="tutor_contact_number">Contact Number</label>
    <input type="text" name="tutor_contact_number" id="tutor_contact_number" value="{{ $tutor->tutor_contact_number ?? old('tutor_contact_number') }}" required autocomplete="off"> --}}

    {{-- <label for="tutor_contact_mail">Contact Mail</label>
    <input type="email" name="tutor_contact_mail" id="tutor_contact_mail" value="{{ $tutor->tutor_contact_mail ?? old('tutor_contact_mail') }}" required autocomplete="off"> --}}

    {{-- <label for="tutor_registry_date">Registry Date</label>
    <input type="date" name="tutor_registry_date" id="tutor_registry_date" value="{{ $tutor->tutor_registry_date ?? old('tutor_registry_date') }}" required autocomplete="off">

    <!-- is_active Checkbox -->
    <label for="is_active">Is Active?</label>
    <input type="hidden" name="is_active" value="0"> <!-- This ensures '0' is sent when unchecked -->
    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $tutor->is_active ?? true) ? 'checked' : '' }}>
    <br> --}}

    <!-- Password -->
    {{-- <label for="password">Password</label>
    <input type="password" name="password" id="password" placeholder="Leave blank to keep current password" autocomplete="off"> --}}
            
    <div class="text-black text-xl bg-red-100 font-londrina p-2 border-red-200 rounded-lg">
                      <x-errors/>
                    </div>

            @if(isset($tutor))
            <!-- Exibe o nome de usuário como somente leitura -->
            <label for="usuario" class="label">Usuário para login</label> 
            <input type="text" name="username" id="username" value="{{ $tutor->user->username }}" required autocomplete="off" readonly class="inputBox bg-zinc-100 dark:bg-slate-100">
            @else
                <label for="usuario" class="label hidden">Usuário para login</label>
                <input type="text" name="username" id="username" value="{{ old('username') }}" required autocomplete="off" class="inputBox bg-zinc-100 dark:bg-slate-100 hidden">
            @endif

            <label for="usuario" class="label">Senha</label> 
            <input type="password" name="password" id="password" placeholder="senha" autocomplete="off" placeholder="Deixar Branco para manter senha" class="inputBox bg-zinc-100 dark:bg-slate-100">

            <label for="usuario" class="label">Numero de Contato <span class="pl-2 font-londrina text-sm text-black dark:text-white">  *Apenas numeros</span></label> 
            <input type="text" name="tutor_contact_number" id="tutor_contact_number" placeholder="00000000000" value="{{ $tutor->tutor_contact_number ?? old('tutor_contact_number') }}" required autocomplete="off" class="inputBox bg-zinc-100 dark:bg-slate-100">

            <label for="usuario" class="label">Email de Contato</label> 
            <input type="email" name="tutor_contact_mail" id="tutor_contact_mail" placeholder="exemplo@gmail.com" value="{{ $tutor->tutor_contact_mail ?? old('tutor_contact_mail') }}" required autocomplete="off" class="inputBox bg-zinc-100 dark:bg-slate-100">

            <label for="usuario" class="label">Nome Completo</label> 
            <input type="text" name="tutor_name" id="tutor_name" placeholder="nome" value="{{ $tutor->tutor_name ?? old('tutor_name') }}" required autocomplete="off" class="inputBox bg-zinc-100 dark:bg-slate-100">

            <label for="usuario" class="label">Numero de Cpf <span class="pl-2 font-londrina text-sm text-black dark:text-white">  *Apenas numeros</span></label> 
            <input type="text" name="tutor_cpf_number" id="tutor_cpf_number" placeholder="00000000000" value="{{ $tutor->tutor_cpf_number ?? old('tutor_cpf_number') }}" maxlength="11" required autocomplete="off" class="inputBox bg-zinc-100 dark:bg-slate-100">

            <label for="usuario" class="label">Data de nascimento</label> 
            <input type="date" name="tutor_birth_date" id="tutor_birth_date" value="{{ $tutor->tutor_birth_date ?? old('tutor_birth_date') }}" required autocomplete="off" class="inputBox bg-zinc-100 dark:bg-slate-100">
            
            <label for="tutor_registry_date" class="label">Data de Registro</label>
            <input type="date" name="tutor_registry_date" id="tutor_registry_date" value="{{ $tutor->tutor_registry_date ?? old('tutor_registry_date') }}" required autocomplete="off" class="inputBox bg-zinc-100 dark:bg-slate-100">

            <label for="usuario" class="label">Rua</label> 
            <input type="text" name="adress_street_name" id="adress_street_name" value="{{ $tutor->address->adress_street_name ?? old('adress_street_name') }}" required autocomplete="off" class="inputBox bg-zinc-100 dark:bg-slate-100">

            <label for="usuario" class="label">Numero de endereco</label> 
            <input type="text" name="adress_number" id="adress_number" value="{{ $tutor->address->adress_number ?? old('adress_number') }}" required autocomplete="off" class="inputBox bg-zinc-100 dark:bg-slate-100">

            <label for="usuario" class="label">CEP <span class="pl-2 font-londrina text-sm text-black dark:text-white">  *Apenas numeros</span></label> 
            <input type="text" name="cep_code" id="cep_code" plcaeholder="00000000" maxlength="8" value="{{ $tutor->address->cep_code ?? old('cep_code') }}" required autocomplete="off" class="inputBox bg-zinc-100 dark:bg-slate-100">

            <input type="button" value="Encontrar Endereço" id="fetchAddressBtn" class="blueButton rounded-md w-full"> <!-- Terminar o botao depois :( -->

            <label for="usuario" class="label">Cidade</label> 
            <input name="city_id" id="city_id" value="{{ $tutor->address->city->name ?? '' }}" class="inputBox bg-gray-300 border-gray-300" disabled="disabled">

            <label for="usuario" class="label">Estado</label> 
            <input name="state_id" id="state_id" value="{{ $tutor->address->state->name ?? '' }}" class="inputBox bg-gray-300 border-gray-300" disabled="disabled">

            <label for="usuario" class="label">Pais</label> 
            <input name="country_id" id="country_id" value="{{ $tutor->address->country->name ?? '' }}" class="inputBox bg-gray-300 border-gray-300" disabled="disabled"> <!-- nao tenho assento no teclado :( -->

            <div class="flex items-center gap-2 w-full ml-4">
              <label for="" class="invertColor font-londrina">Esta ativo?</label>
              <input type="checkbox" name="is_active" value="1" {{ old('is_active', $tutor->is_active ?? true) ? 'checked' : '' }} class="ml-4">
            </div>

            



    <script>
        document.getElementById('fetchAddressBtn').addEventListener('click', function() {
            const cep = document.getElementById('cep_code').value;
    
            fetch(`/cep/${cep}`)
                .then(response => response.json())
                .then(data => {
                    if (data.city) {
                        // Atribui o nome da cidade, estado e país ao valor dos campos de input
                        document.getElementById('city_id').value = data.city.name;
                        document.getElementById('state_id').value = data.state.name;
                        document.getElementById('country_id').value = data.country.name;
    
                        // Exibe os valores atualizados, se necessário
                        document.getElementById('cityDisplay').innerText = data.city.name;
                        document.getElementById('stateDisplay').innerText = data.state.name;
                        document.getElementById('countryDisplay').innerText = data.country.name;
    
                        document.getElementById('addressDisplay').style.display = 'block';
                    } else {
                        alert('Endereço não encontrado!');
                    }
                })
                .catch(error => console.error('Erro ao buscar endereço:', error));
        });
    </script>
    
</div>