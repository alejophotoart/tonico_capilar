<div
    class="modal fade"
    id="profileModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <label style="font-size: 1.7em;" class="modal-title" id="exampleModalLabel">Perfil</label>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <form action="" method="PUT" class="row g-3" enctype="multipart/form-data">
                @method('patch') @csrf
                    <div class="mb-3 row">
                        <div class="d-flex justify-content-center">
                            <div id="image-edit-profile">
                                <img
                                    src=""
                                    alt=""
                                    class="img-circle elevation-2"
                                    id="imageUser-profile"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">{{
                            __("Type identification")
                        }}</label>
                        <select class="form-control" id="type_id" name="type_id">
                            <option value="0" selected
                                >---Seleccione tipo de documento---</option
                            >
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label for="inputPassword4" class="form-label">{{
                            __("Identification")
                        }}</label>
                        <input
                            type="number"
                            class="form-control"
                            placeholder="identificacion"
                            id="identificacion"
                            name="identificacion"
                        />
                    </div>
                    <div class="col-6">
                        <label for="inputAddress" class="form-label">{{
                            __("Name")
                        }}</label>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Nombre completo"
                            id="nombre"
                            name="nombre"
                        />
                    </div>
                    <div class="col-6">
                        <label for="inputAddress2" class="form-label">{{
                            __("Email")
                        }}</label>
                        <input
                            type="email"
                            class="form-control"
                            placeholder="Correo Electronico"
                            id="correo"
                            name="correo"
                        />
                    </div>
                    <div class="col-md-6">
                        <label for="inputCity" class="form-label">{{
                            __("Phone")
                        }}</label>
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Telefono"
                            onkeypress="return validePhone(event);"
                            id="telefono"
                            name="telefono"
                        />
                    </div>
                    @if(auth()->user()->role_id == 1 ||
                    auth()->user()->role_id == 2)
                    <div class="col-md-6">
                        <label class="form-label">{{
                            __("Employee type")
                        }}</label>
                        <select
                            id="rol"
                            name="rol"
                            class="form-control"
                        >

                        </select>
                    </div>
                    @else
                    <div class="col-md-6">
                        <label class="form-label">{{
                            __("Employee type")
                        }}</label>
                        <select
                            id="rol"
                            name="rol"
                            class="form-control"
                        >

                        </select>
                    </div>
                    @endif
                    <div class="col-md-4">
                        <label class="form-label">{{
                            __("Country")
                        }}</label>
                        <select
                            class="form-control"
                            id="pais"
                            name="pais"
                            onchange="changeCountryType(this.value)"
                        >
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{
                            __("State")
                        }}</label>
                        <select
                            class="form-control"
                            id="estado"
                            name="estado"
                            onchange="changeStateType(this.value)"
                            {{ old('pais') ? '' : 'disabled' }}

                        >
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">{{
                            __("City")
                        }}</label>
                        <select
                            class="form-control"
                            id="ciudad"
                            name="ciudad"
                        >
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">{{ __('Cargar imagen') }}</label>
                        <input class="form-control"
                        type="file"
                        id="imgprofile"
                        name="imgprofile"
                        class="imgprofile" />
                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-header" style="background-color: #343a40; color: #fff;">
                            Estadistica de Ventas
                            <span id="salesTot" class="float-right badge bg-light"></span>
                            </div>
                        <ul class="list-group list-group-flush">
                          <li class="list-group-item">

                                Nuevas <span id="salesReg" class="float-right badge bg-primary"></span>

                          </li>
                          <li class="list-group-item">

                                Entregadas <span id="salesRea" class="float-right badge bg-success"></span>

                          </li>
                          <li class="list-group-item">

                                Canceladas <span id="salesCan" class="float-right badge bg-danger"></span>

                          </li>
                          <li class="list-group-item">

                                Pendientes <span id="salesPen" class="float-right badge bg-warning"></span>

                          </li>
                        </ul>
                      </div>
                    </div>

                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-danger"
                        data-bs-dismiss="modal"
                    >
                        Cerrar
                    </button>
                    <button onclick="EditProfile('{{ auth()->user()->id }}' , '{{ auth()->user()->name }}');"
                        type="button" class="btn btn-dark">
                    {{ __('Save changes') }}
                    </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script
    src="https://code.jquery.com/jquery-3.6.0.js"
    integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous"
></script>
<script>
    var country_code_value =
    '{{ old("pais") }}' || "{{ auth()->user()->city->state->country->id }}";
if (country_code_value && country_code_value != "") {
    changeCountryType(country_code_value);
}
var state_code_value =
    '{{ old("estado") }}' || "{{ auth()->user()->city->state->id }}";
if (state_code_value && state_code_value != "") {
    changeStateType(state_code_value);
}

function changeCountryType(country_code) {
    var state_id = "{{ auth()->user()->city->state_id }}";

    $.ajax({
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: "/optionCountry/state/" + country_code,
        data: null,
        success: function(r) {
            if (!r) {
                r = JSON.parse(r);
            }
            if (r) {
                $("#estado").prop("disabled", false);
                $("#estado option").remove();
                for (var i = 0; i < r.d.states.length; i++) {
                    if (state_id == r.d.states[i].id) {
                        $("#estado").append(
                            '<option value="' +
                                r.d.states[i].id +
                                '" selected>' +
                                r.d.states[i].name +
                                "</option>"
                        );
                    } else {
                        $("#estado").append(
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
    var city_id = "{{ auth()->user()->city_id }}";

    $.ajax({
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: "/optionState/city/" + state_code,
        data: null,
        success: function(r) {
            if (!r) {
                r = JSON.parse(r);
            }
            if (r) {
                $("#ciudad").prop("disabled", false);
                $("#ciudad option").remove();
                for (var i = 0; i < r.d.cities.length; i++) {
                    if (city_id == r.d.cities[i].id) {
                        $("#ciudad").append(
                            '<option value="' +
                                r.d.cities[i].id +
                                '" selected>' +
                                r.d.cities[i].name +
                                "</option>"
                        );
                    } else {
                        $("#ciudad").append(
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
</script>
<script src="/adminlte/js/profile/ShowInfo.js"></script>
<script src="/adminlte/js/profile/EditProfile.js"></script>