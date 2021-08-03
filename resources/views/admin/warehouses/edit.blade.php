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
                    name="name_warehouse"
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
                <select class="form-control" id="country_id_warehouse" name="country_id_warehouse"
                onchange="changeCountryType(this.value)">
                  </select>
                  <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-globe-americas"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
            <select class="form-control" id="state_id_warehouse" name="state_id_warehouse" onchange="changeStateType(this.value)"
            {{ old('country_id_warehouse') ? '' : 'disabled' }}>
                  </select>
                  <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-flag-usa"></span>
                    </div>
                </div>
            </div>
            <div class="input-group mb-3">
            <select class="form-control" id="city_id_warehouse" name="city_id_warehouse">
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
          <button type="button" id="buttonUpdate" onclick="editInfowarehouse()" data-id="" class="btn btn-dark">Guardar Cambios</button>
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

</script>
<script src="/adminlte/js/warehouses/editWarehouses.js"></script>

