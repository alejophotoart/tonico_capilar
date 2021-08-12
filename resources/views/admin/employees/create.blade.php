@extends('admin.layout') @section('title', __('Create employee')) @section('titleSup', __('Employees'))
@section('explorer')
<li class="breadcrumb-item">
    <a class="darkMode-text" href="{{ route('employees.index') }}">{{ __("Employees") }}</a>
</li>
<li class="breadcrumb-item active">
    {{ __("Create employee") }}
</li>
@endsection @section('content')

<div class="register-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center darkMode-bbg">
            <b
                ><span
                    class="fas fa-user-plus"
                    style="margin-right: 5px;"
                ></span>
                {{ __("i18n.screen_login.text_nav_login1") }}</b
            >
        </div>
        <div class="card-body darkMode-bbg">
            <p class="login-box-msg">
                {{ __("Register new employee") }}
            </p>

            <form action="" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <select
                        id="type_identification_id"
                        name="type_identification_id"
                        class="form-control"
                    >
                        <option value="0"
                            >---Seleccione tipo de documento---</option
                        >
                        @foreach( $type_identification as $ti )
                        <option value="{{ $ti->id }}">{{ $ti->name }}</option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="far fa-id-badge"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input
                        type="text"
                        class="form-control"
                        placeholder="identificacion"
                        id="identification"
                        name="identification"
                    />
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="far fa-id-card"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Nombre completo"
                        id="name"
                        name="name"
                    />
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input
                        type="email"
                        class="form-control"
                        placeholder="Correo Electronico"
                        id="email"
                        name="email"
                    />
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" style="max-width: 55px;" value="+57" name="phonecode" id="phonecode" disabled>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Telefono"
                        id="phone"
                        name="phone"
                        onkeypress="return validePhone(event);"
                    />
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-mobile-alt"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <select id="role_id" name="role_id" class="form-control">
                        <option>---Seleccione tipo de empleado---</option>
                        @foreach( $roles as $r )
                        <option value="{{ $r->id }}">{{ $r->name }}</option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-user-shield"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <select id="country_id" name="country_id" class="form-control"
                    onchange="changeCountryType(this.value)">
                        <option selected value="0"
                            >---Seleccione pais de origen---</option
                        >
                        @foreach( $country as $c )
                        <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-globe-americas"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <select
                        id="state_id"
                        name="state_id"
                        class="form-control"
                        onchange="changeStateType(this.value)"
                        {{ old('country_id') ? '' : 'disabled' }}
                    >
                    <option selected value="0">---Seleccione estado---</option>
                    </select>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-flag-usa"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <select id="city_id" name="city_id" class="form-control" onchange="changeCity(this.value)"
                    {{ old('state_id') ? '' : 'disabled' }}>
                        <option selected value="0">---Seleccione ciudad---</option>
                    </select>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-city"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input
                        type="password"
                        class="form-control"
                        placeholder="Password"
                        id="password"
                        name="password"
                    />
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input
                        id="password-confirm"
                        type="password"
                        class="form-control"
                        placeholder="Password confirm"
                    />
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <!-- /.col -->
                    <div class="d-grid gap-2">
                        <button
                            onclick="registerEmployee();"
                            class="btn btn-dark"
                            type="button"
                        >
                            {{ __("Employee register") }}
                        </button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.form-box -->
    </div>
    <!-- /.card -->
</div>
<script>
    var state_code_value = '{{ old("state_id") }}';
        if (state_code_value && state_code_value != "") {
            changeStateType(state_code_value);
        }

    var country_code_value = '{{ old("country_id") }}';
        if (country_code_value && country_code_value != "") {
            changeCountryType(country_code_value);
        }
        function changeCountryType(country_code) {
            console.log(country_code);
            var state_id = localStorage.getItem("state_id");

            $.ajax({
                type: "GET",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                url: "/optionCountry/state/" + country_code,
                data: null,
                success: function(r) {
                    console.log(r);
                    if (!r) {
                        r = JSON.parse(r);
                    }
                    if (r) {
                        $("#state_id").prop("disabled", false);
                        $("#state_id").append('<option value="0" selected disabled></option>');
                        $("#city_id").append('<option value="0" selected disabled></option>');
                        $("#state_id option").remove();
                        $("#city_id option").remove();
                        for (var i = 0; i < r.d.states.length; i++) {
                            if (state_id && state_id != "" && r.d.states[i].id == state_id) {
                                $("#state_id").append(
                                    '<option value="' +
                                        r.d.states[i].id +
                                        '" selected>' +
                                        r.d.states[i].name +
                                        "</option>"
                                );
                            } else {
                                $("#state_id").append(
                                    '<option value="' +
                                        r.d.states[i].id +
                                        '">' +
                                        r.d.states[i].name +
                                        "</option>"
                                );
                            }
                        }
                    }
                },
                error: function(textStatus, errorThrown) {
                    alert("error");
                }
            });
        }

        function changeStateType(state_code) {
            var city_id = localStorage.getItem("city_id");


            $.ajax({
                type: "GET",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                url: "/optionState/city/" + state_code,
                data: null,
                success: function(r) {
                    console.log(r);
                    if (!r) {
                        r = JSON.parse(r);
                    }
                    if (r) {
                        $("#city_id").prop("disabled", false);
                        $("#city_id").append('<option value="0" selected disabled>Municipio</option>');
                        $("#city_id option").remove();
                        for (var i = 0; i < r.d.cities.length; i++) {
                            if (city_id && city_id != "" && r.d.cities[i].id == city_id) {
                                $("#city_id").append(
                                    '<option value="' +
                                        r.d.cities[i].id +
                                        '" selected>' +
                                        r.d.cities[i].name +
                                        "</option>"
                                );
                            } else {
                                $("#city_id").append(
                                    '<option value="' +
                                        r.d.cities[i].id +
                                        '">' +
                                        r.d.cities[i].name +
                                        "</option>"
                                );
                            }
                        }
                    }
                },
                error: function(textStatus, errorThrown) {
                    alert("error");
                }
            });
        }
        function changeCity(city_id) {
            localStorage.setItem("city_id", city_id);
        }
</script>
<script src="/adminlte/js/employees/ValidateCreateUser.js"></script>
@endsection
