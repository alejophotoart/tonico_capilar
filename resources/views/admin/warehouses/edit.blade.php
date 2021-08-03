<!-- Modal -->
<div class="modal fade" id="editWarehouseModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Editar bodega</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="input-group mb-3">
                <input
                    type="text"
                    class="form-control"
                    placeholder="Nombre o alias de la bodega"
                    id="name_warehouse"
                    name="name"
                    autofocus
                    {{ old('name_warehouse') }}
                />
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-warehouse"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <select id="state_warehouse_id" name="state_warehouse_id" class="form-control">
                    <option value="0" selected disabled>---Estado de la bodega---</option>
                </select>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-briefcase"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <select class="form-control" id="country_id_warehouse" name="country_id" data-live-search="true"
                onchange="changeCountryType(this.value)">
                  </select>
                  <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-globe-americas"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
            <select class="form-control" id="state_id_warehouse" name="state_id" onchange="changeStateType(this.value)"
            {{ old('country_id_warehouse') ? '' : 'disabled' }} data-live-search="true">
                  </select>
                  <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-flag-usa"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
            <select class="form-control multi_select" data-live-search="true"
                id="city_id_warehouse" name="city_id">
            </select>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-city"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
<script>
    var country_code_value ='{{ old("country_id_warehouse") }}';
if (country_code_value && country_code_value != "") {
    changeCountryType(country_code_value);
}
var state_code_value =
    '{{ old("state_id_warehouse") }}';
if (state_code_value && state_code_value != "") {
    changeStateType(state_code_value);
}

function changeCountryType(country_code) {
    console.log(country_code);

    var state_id = localStorage.getItem("state_id_warehouse");;

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
                $("#state_id_warehouse").prop("disabled", false);
                $("#state_id_warehouse option").remove();
                for (var i = 0; i < r.d.states.length; i++) {
                    if (state_id == r.d.states[i].id) {
                        $("#state_id_warehouse").append(
                            '<option value="' +
                                r.d.states[i].id +
                                '" selected>' +
                                r.d.states[i].name +
                                "</option>"
                        );
                    } else {
                        $("#state_id_warehouse").append(
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
console.log(state_code);
    var city_id = localStorage.getItem("city_id_warehouse");

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
                $("#city_id_warehouse").prop("disabled", false);
                $("#city_id_warehouse option").remove();
                for (var i = 0; i < r.d.cities.length; i++) {
                    if (city_id == r.d.cities[i].id) {
                        $("#city_id_warehouse").append(
                            '<option value="' +
                                r.d.cities[i].id +
                                '" selected>' +
                                r.d.cities[i].name +
                                "</option>"
                        );
                    } else {
                        $("#city_id_warehouse").append(
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
