<!-- Modal -->
<div class="modal fade" id="editModalProductWarehouse" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="name_product"></h5>
            <h5 class="modal-title" id="space"></h5>
            <h5 class="modal-title" id="name_productWarehouse"></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <label for="inputQuantity" class="form-label">{{
                __("Cuanta Cantidad Agregaras ?")
            }}</label>
            <div class="input-group mb-3">
                <input
                    type="number"
                    class="form-control"
                    placeholder="Cantidad que agregaras"
                    id="quantity"
                    name="quantity"
                />
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-balance-scale-left"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" id="updateQuantity" class="btn btn-dark" data-id="" data-product_id="" data-warehouse_id=""
            onclick="editQuantity()">Guardar</button>
        </div>
      </div>
    </div>
  </div>
  <script src="/adminlte/js/productWarehouses/editProductWarehouses.js"></script>
