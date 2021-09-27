<div
    class="modal fade"
    id="ModalProducts"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <label
                    class="modal-title"
                    id="name"
                    style="font-size: 1.7em;"
                ></label>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 row">
                    <label for="" class="col-sm-2 col-form-label">{{
                        __("Code")
                    }}</label>
                    <div class="col-sm-10 heigh-text">
                        <input
                            readonly
                            class="form-control-plaintext"
                            style="text-align: start; padding-left: 10px;"
                            id="code"
                        />
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="" class="col-sm-2 col-form-label">{{
                        __("Imagen")
                    }}</label>
                    <div class="col-sm-10" id="content-img">
                        <img id="imagenProduct" src="" alt="" />
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="" class="col-sm-2 col-form-label">{{
                        __("Precio de Coste")
                    }}</label>
                    <div
                        class="col-sm-10 heigh-text
                    "
                    >
                        <input
                            type="text"
                            readonly
                            class="form-control-plaintext "
                            style="text-align: start; padding-left: 10px;"
                            id="price"
                        />
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="" class="col-sm-2 col-form-label">{{
                        __("Quantity")
                    }}</label>
                    <div
                        class="col-sm-10 heigh-text
                    "
                    >
                        <input
                            type="number"
                            readonly
                            class="form-control-plaintext "
                            style="text-align: start; padding-left: 10px;"
                            id="quantity"
                        />
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="" class="col-sm-2 col-form-label">{{
                        __("Bodegas")
                    }}</label>
                    <div class="col-sm-10 heigh-text">
                        <textarea
                        style=" padding: 10px;
                                width: 80%;
                                height: 100px;
                                max-height: 140;
                                min-height: 50px;"
                        type="text"
                        readonly
                        class="form-control-plaintext"
                        id="warehouses"
                    ></textarea>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="" class="col-sm-2 col-form-label">{{
                        __("Descripcion")
                    }}</label>
                    <div class="col-sm-10 heigh-text">
                        <textarea
                            style=" padding: 10px;
                                    width: 80%;
                                    height: 115px;
                                    max-height: 200px;
                                    min-height: 50px;"
                            type="text"
                            readonly
                            class="form-control-plaintext description-modal"
                            id="description"
                        ></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function ShowInfoProduct(id) {
        $.ajax({
            url: "/productos/" + id,
            type: "GET",
            contentType: "application/json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                contentType: "application/json"
            },
            success: function(r) {
                console.log(r);
                products = r;
                product_warehouse = r.product_warehouses
                console.log(product_warehouse);

                const options = {
                    style: "currency",
                    currency: "USD",
                    maximumSignificantDigits: 3
                };
                const numberFormat = new Intl.NumberFormat("en-US", options);
                if (r) {
                    $("#ModalProducts").modal("show");
                    $("#code").val(products.code);
                    $("#name").text(products.name);
                    $("#price").val(numberFormat.format(products.price));
                    $("#quantity").val(products.quantity);
                    $("#description").val(products.description);
                }
                var arraWare = [];
                product_warehouse.forEach(pw => {
                    pw.warehouses.forEach(pww => {
                        arraWare.push(pww.name);
                    });
                });

                $("#warehouses").val(arraWare);

                if (products.img !== null) {
                    $("#imagenProduct").attr(
                        "src",
                        products.link + products.img
                    );
                } else {
                    $("#imagenProduct").attr(
                        "src",
                        "/adminlte/img/products/default.png"
                    );
                }
            }
        });
    }
</script>
