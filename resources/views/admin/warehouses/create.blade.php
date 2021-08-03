 <!-- Modal -->
  <div class="modal fade" id="CreateWarehouseModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Crear Bodega</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="input-group mb-3">
                <input
                    type="text"
                    class="form-control"
                    placeholder="Nombre o alias de la bodega"
                    id="name"
                    name="name"
                    autofocus
                    {{ old('name') }}
                />
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-warehouse"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
                <select class="form-control" id="country_id" name="country_id" data-live-search="true">
                  </select>
                  <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-globe-americas"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
            <select class="form-control" id="state_id" name="state_id"
            {{ old('country_id') ? '' : 'disabled' }} data-live-search="true"
                title="Departamento donde se guardara este producto">
                  </select>
                  <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-flag-usa"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
            <select class="form-control multi_select" data-live-search="true" title="Seleccione la bodega del producto"
                id="city_id" name="city_id" {{ old('state_id') ? '' : 'disabled' }}>
            </select>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-city"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-dark" onclick="createWarehouse()">Registrar Bodega</button>
        </div>
      </div>
    </div>
  </div>
  <script>
    $(function () {
        $('#country_id').selectpicker();
        $('#state_id').selectpicker();
        $('#city_id').selectpicker();

        $('#country_id').change(function () {
            var selectedCountry = $('#country_id').val();

            var country_code_value = '{{ old("country_id") }}';
            if (country_code_value && country_code_value != "") {
                changeCountryType(country_code_value);
            }

            var state_id = localStorage.getItem("state_id");
            $.ajax({
                type: "GET",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                url: "/optionCountry/state/" + selectedCountry,
                data: null,
                success: function(r) {
                    if (!r) {
                        r = JSON.parse(r);
                    }
                    if (r) {
                        $("#state_id").prop("disabled", false);
                        $("#state_id").append('<option value="0" disabled> Seleccion departamento</option>');
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
                        $('#state_id').selectpicker('refresh');
                        $('#state_id').selectpicker('render');
                    }
                },
                error: function(textStatus, errorThrown) {
                    alert("error");
                }
            });

        });
        $('#state_id').change(function () {
            var selectedState = $('#state_id').val();
            var state_code_value = '{{ old("state_id") }}';
            if (state_code_value && state_code_value != "") {
                changeStateType(state_code_value);
            }
            var city_id = localStorage.getItem("city_id");

            $.ajax({
                type: "GET",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                url: "/optionState/city/" + selectedState,
                data: null,
                success: function(r) {
                    if (!r) {
                        r = JSON.parse(r);
                    }
                    if (r) {
                        $("#city_id").prop("disabled", false);
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
                        $('#city_id').selectpicker('refresh');
                        $('#city_id').selectpicker('render');
                    }
                },
                error: function(textStatus, errorThrown) {
                    alert("error");
                }
            });
        });

        $('#city_id').change(function () {
            var selectedCity = document.getElementById("city_id").value;
            localStorage.setItem("city_id", selectedCity);
        });
    });
</script>
