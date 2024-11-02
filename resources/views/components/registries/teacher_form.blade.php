<div>
    <!-- Check if $teacher is set to determine if we're editing or creating -->
    @if(isset($teacher))
        <!-- Display username as read-only -->
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="{{ $teacher->user->username }}" required autocomplete="off" readonly>
    @else
        <input type="hidden" name="username" value="{{ old('username') }}">
    @endif

    <!-- Address Fields -->
    <label for="cep_code">CEP Code</label>
    <input type="text" name="cep_code" id="cep_code" maxlength="8" value="{{ $teacher->address->cep_code ?? old('cep_code') }}" required autocomplete="off">

    <label for="adress_street_name">Street Name</label>
    <input type="text" name="adress_street_name" id="adress_street_name" value="{{ $teacher->address->adress_street_name ?? old('adress_street_name') }}" required autocomplete="off">

    <label for="adress_number">Address Number</label>
    <input type="text" name="adress_number" id="adress_number" value="{{ $teacher->address->adress_number ?? old('adress_number') }}" required autocomplete="off">

    <button type="button" id="fetchAddressBtn">Fetch Address</button>

    <!-- Hidden Fields to Lock City, State, and Country -->
    <input type="hidden" name="city_id" id="city_id" value="{{ $teacher->address->city_id ?? '' }}">
    <input type="hidden" name="state_id" id="state_id" value="{{ $teacher->address->state_id ?? '' }}">
    <input type="hidden" name="country_id" id="country_id" value="{{ $teacher->address->country_id ?? '' }}">

    <!-- City, State, and Country Display -->
    <div id="addressDisplay" style="display: {{ isset($teacher) ? 'block' : 'none' }};">
        <p>City: <span id="cityDisplay">{{ $teacher->address->city->name ?? '' }}</span></p>
        <p>State: <span id="stateDisplay">{{ $teacher->address->state->name ?? '' }}</span></p>
        <p>Country: <span id="countryDisplay">{{ $teacher->address->country->name ?? '' }}</span></p>
    </div>

    <!-- Teacher Name -->
    <br>
    <label for="teacher_name">Teacher Name</label>
    <input type="text" name="teacher_name" id="teacher_name" value="{{ $teacher->teacher_name ?? old('teacher_name') }}" required autocomplete="off">

    <!-- Other Teacher Fields -->
    <label for="teacher_birth_date">Birth Date</label>
    <input type="date" name="teacher_birth_date" id="teacher_birth_date" value="{{ $teacher->teacher_birth_date ?? old('teacher_birth_date') }}" required autocomplete="off">

    <label for="teacher_cpf_number">CPF Number</label>
    <input type="text" name="teacher_cpf_number" id="teacher_cpf_number" value="{{ $teacher->teacher_cpf_number ?? old('teacher_cpf_number') }}" maxlength="11" required autocomplete="off">

    <label for="teacher_contact_number">Contact Number</label>
    <input type="text" name="teacher_contact_number" id="teacher_contact_number" value="{{ $teacher->teacher_contact_number ?? old('teacher_contact_number') }}" required autocomplete="off">

    <label for="teacher_contact_mail">Contact Mail</label>
    <input type="email" name="teacher_contact_mail" id="teacher_contact_mail" value="{{ $teacher->teacher_contact_mail ?? old('teacher_contact_mail') }}" required autocomplete="off">

    <label for="teacher_registry_date">Registry Date</label>
    <input type="date" name="teacher_registry_date" id="teacher_registry_date" value="{{ $teacher->teacher_registry_date ?? old('teacher_registry_date') }}" required autocomplete="off">

    <!-- is_active Checkbox -->
    <label for="is_active">Is Active?</label>
    <input type="hidden" name="is_active" value="0"> <!-- This ensures '0' is sent when unchecked -->
    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $teacher->is_active ?? true) ? 'checked' : '' }}>
    <br>

    <!-- Coordinator Checkbox -->
    <label for="coordinator">Is Coordinator?</label>
    <input type="hidden" name="coordinator" value="0"> <!-- This ensures '0' is sent when unchecked -->
    <input type="checkbox" name="coordinator" value="1" {{ old('coordinator', $teacher->coordinator ?? false) ? 'checked' : '' }}>

    <br>
    <!-- Password -->
    <label for="password">Password</label>
    <input type="password" name="password" id="password" placeholder="Leave blank to keep current password" autocomplete="off">

    <!-- Errors -->
    <x-errors />

    <script>
        document.getElementById('fetchAddressBtn').addEventListener('click', function() {
            const cep = document.getElementById('cep_code').value;

            fetch(`/cep/${cep}`)
                .then(response => response.json())
                .then(data => {
                    if (data.city) {
                        document.getElementById('city_id').value = data.city.id; 
                        document.getElementById('state_id').value = data.state.id;
                        document.getElementById('country_id').value = data.country.id;

                        document.getElementById('cityDisplay').innerText = data.city.name;
                        document.getElementById('stateDisplay').innerText = data.state.name;
                        document.getElementById('countryDisplay').innerText = data.country.name;

                        document.getElementById('addressDisplay').style.display = 'block';
                    } else {
                        alert('Address not found!');
                    }
                })
                .catch(error => console.error('Error fetching address:', error));
        });
    </script>
</div>