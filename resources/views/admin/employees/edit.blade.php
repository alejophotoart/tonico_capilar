@extends('admin.layout') @section('title', __('Edit employee')) @section('titleSup', __('Employees'))
@section('explorer')
<li class="breadcrumb-item">
    <a class="darkMode-text" href="{{ route('employees.index') }}">{{ __("Employees") }}</a>
</li>
<li class="breadcrumb-item active">
    {{ __("Edit employee") }}
</li>
@endsection @section('content')
<div class="register-box">
    <div class="card card-outline card-primary">
        <div class="card-header darkMode-bbg text-center">
            <b
                ><span
                    class="fas fa-user-plus"
                    style="margin-right: 5px;"
                ></span>
                {{ __("i18n.screen_login.text_nav_login1") }}</b
            >
        </div>
        <div class="card-body darkMode-bbg">
            @if($user->img !== null)
            <div class="d-flex justify-content-center">
                <div class="darkMode-circle" id="image-edit">
                    <img
                        src="{{$user->link}}{{$user->img}}"
                        alt="{{$user->name}}"
                        class="img-circle elevation-2"
                        id="imageUser"
                    />
                </div>
            </div>
            @else
            <div class="d-flex justify-content-center">
                <div class="darkMode-circle" id="image-edit">
                    <img
                        src="/adminlte/img/users/default.png"
                        alt="{{$user->name}}"
                        class="img-circle elevation-2"
                        id="imageUser"
                    />
                </div>
            </div>
            @endif
            <form action="" method="POST">
                @method('patch') @csrf
                <div class="input-group mb-3">
                    <select
                        id="type_identification_id"
                        name="type_identification_id"
                        class="form-control"
                    >
                        <option value="0" selected disabled
                            >---Seleccione tipo de documento---</option
                        >
                        @foreach( $type_identification as $ti )
                        @if($user->type_identification_id == $ti->id)
                        <option value="{{ $ti->id }}" selected>{{ $ti->name }}</option>
                        @else
                        <option value="{{ $ti->id }}" selected>{{ $ti->name }}</option>
                        @endif
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
                        value="{{ $user->identification }}"
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
                        value="{{ $user->name }}"
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
                        value="{{ $user->email }}"
                    />
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" style="max-width: 55px;"  name="phonecode" id="phonecode" disabled>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Telefono"
                        id="phone"
                        name="phone"
                        onkeypress="return validePhone(event);"
                        value="{{ $user->phone }}"
                    />
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-mobile-alt"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <select id="employee_state_id" name="employee_state_id" class="form-control">
                        <option value="0" selected disabled>---Estado del empleado---</option>
                        @foreach( $state_employee as $se )
                        @if($user->employee_state_id == $se->id)
                        <option value="{{ $se->id }}" selected>{{ $se->name }}</option>
                        @else
                        <option value="{{ $se->id }}">{{ $se->name }}</option>
                        @endif
                        @endforeach
                    </select>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-briefcase"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <select id="role_id" name="role_id" class="form-control">
                        <option value="0" selected disabled>---Seleccione tipo de empleado---</option>
                        @foreach( $roles as $r )
                        @if($user->role_id == $r->id)
                        <option value="{{ $r->id }}" selected>{{ $r->name }}</option>
                        @else
                        <option value="{{ $r->id }}">{{ $r->name }}</option>
                        @endif
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
                        <option value="0" disabled
                            >---Seleccione pais de origen---</option
                        >
                        @foreach( $country as $c )
                        @if($user->city->state->country->id == $c['id'])
                        <option value="{{ $c['id'] }}" selected>{{ $c['name'] }}</option>
                        @else
                        <option value="{{ $c['id'] }}">{{ $c['name'] }}</option>
                        @endif
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
                    <option selected>---Seleccione estado---</option>
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
                    </select>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-city"></span>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <!-- /.col -->
                    <div class="d-grid gap-2">
                        <button
                            onclick="EditEmployee( '{{ $user->id }}' );"
                            class="btn btn-dark"
                            type="button"
                        >
                            {{ __("Edit employee") }}
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
<script
    src="https://code.jquery.com/jquery-3.6.0.js"
    integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous"
></script>
<script>

var country_code_value = '{{ old("country_id") }}' || "{{ $user->city->state->country->id }}";
        if (country_code_value && country_code_value != "") {
            changeCountryType(country_code_value);
        }

    var state_code_value = '{{ old("state_id") }}' || "{{ $user->city->state->id }}";
        if (state_code_value && state_code_value != "") {
            changeStateType(state_code_value);
        }

        function changeCountryType(country_code) {
            var state_id = "{{ $user->city->state->id }}";
            let country_id = document.getElementById("country_id").value;
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
                        for (var c = 0; c < r.country.length; c++) {
                            if(r.country[c].id == country_id){
                                $("#phonecode").val("+" + r.country[c].phonecode);

                            }
                        }
                        $("#state_id").prop("disabled", false);
                        $("#state_id option").remove();
                        $("#state_id").append('<option value="0" selected>---Seleccione estado---</option>');
                        for (var i = 0; i < r.d.states.length; i++) {
                            if (state_id == r.d.states[i].id ) {
                                $("#state_id").append(
                                    '<option value="' + r.d.states[i].id + '" selected>' + r.d.states[i].name + "</option>"
                                );
                            } else {
                                $("#state_id").append(
                                    '<option value="' + r.d.states[i].id +'">' + r.d.states[i].name + "</option>"
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
             var city_id = "{{ $user->city_id }}";

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
                            if (city_id == r.d.cities[i].id) {
                                $("#city_id").append(
                                    '<option value="' + r.d.cities[i].id + '" selected>' + r.d.cities[i].name + "</option>"
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
<script src="/adminlte/js/employees/ValidateEditUser.js"></script>
@endsection
