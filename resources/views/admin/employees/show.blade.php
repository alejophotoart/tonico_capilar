<!-- Modal -->
<div
    class="modal fade"
    id="ModalEmployees"
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
                    <div class="d-flex justify-content-center">
                        <div id="image-edit">
                            <img
                                src=""
                                alt=""
                                class="img-circle elevation-2"
                                id="imageUser"
                            />
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="" class="col-sm-2 col-form-label">{{
                        __("Cargo")
                    }}</label>
                    <div class="col-sm-10 heigh-text">
                        <input
                            readonly
                            class="form-control-plaintext"
                            style="text-align: center;"
                            id="role"
                        />
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="" class="col-sm-2 col-form-label">{{
                        __("Type identification")
                    }}</label>
                    <div class="col-sm-10 input-tex">
                        <input
                            readonly
                            class="form-control-plaintext"
                            style="text-align: center;"
                            id="type_identification_id"
                        />
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="" class="col-sm-2 col-form-label">{{
                        __("Identification")
                    }}</label>
                    <div
                        class="col-sm-10 heigh-text
                    "
                    >
                        <input
                            type="number"
                            readonly
                            class="form-control-plaintext "
                            id="identification"
                        />
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="" class="col-sm-2 col-form-label">{{
                        __("Phone")
                    }}</label>
                    <div class="col-sm-10 heigh-text">
                        <input
                            type="number"
                            readonly
                            class="form-control-plaintext "
                            id="phone"
                        />
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">{{
                        __("Email")
                    }}</label>
                    <div class="col-sm-10 input-tex">
                        <input
                            type="text"
                            readonly
                            class="form-control-plaintext"
                            id="email"
                        />
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">{{
                        __("City")
                    }}</label>
                    <div class="col-sm-10 input-tex">
                        <input
                            type="text"
                            readonly
                            class="form-control-plaintext"
                            id="city"
                        />
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">{{
                        __("State")
                    }}</label>
                    <div class="col-sm-10 heigh-text">
                        <input
                            type="text"
                            readonly
                            class="form-control-plaintext"
                            id="state"
                        />
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">{{
                        __("Country")
                    }}</label>
                    <div class="col-sm-10 heigh-text">
                        <input
                            type="text"
                            readonly
                            class="form-control-plaintext"
                            id="country"
                        />
                    </div>
                </div>

                <div class="mb-3 row">
                    <label class="col-sm-2 col-form-label">{{
                        __("State employee")
                    }}</label>
                    <div class="col-sm-10 input-tex">
                        <input
                            type="text"
                            readonly
                            class="form-control-plaintext"
                            id="state_employee"
                        />
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="card">
                        <div
                            class="card-header"
                            style="background-color: #343a40; color: #fff;"
                        >
                            Estadistica de Ventas
                            <span
                                id="salesTotUser"
                                class="float-right badge bg-light"
                            ></span>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                Nuevas
                                <span
                                    id="salesRegUser"
                                    class="float-right badge bg-primary"
                                ></span>
                            </li>
                            <li class="list-group-item">
                                Entregadas
                                <span
                                    id="salesReaUser"
                                    class="float-right badge bg-success"
                                ></span>
                            </li>
                            <li class="list-group-item">
                                Canceladas
                                <span
                                    id="salesCanUser"
                                    class="float-right badge bg-danger"
                                ></span>
                            </li>
                            <li class="list-group-item">
                                Pendientes
                                <span
                                    id="salesPenUser"
                                    class="float-right badge bg-warning"
                                ></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function ShowInfoUser(id) {
        $.ajax({
            url: "/empleados/" + id,
            type: "GET",
            contentType: "application/json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                contentType: "application/json"
            },
            success: function(r) {
                console.log(r);
                var saleReg = 0;
                var saleRea = 0;
                var saleCan = 0;
                var salePen = 0;
                var saleTot = 0;

                user = r[0];
                type_identification = r[0].type_identification;
                role = r[0].role;
                city = r[0].city;
                state = r[0].city.state;
                country = r[0].city.state.country;
                state_employee = r[0].employee_state;
                salesReg = r[1];
                salesRea = r[2];
                salesCan = r[3];
                salesPen = r[4];
                salesTot = r[5];

                if (r) {
                    for (var i = 0; i < salesReg.length; i++) {
                        if (salesReg.length != 0) {
                            saleReg++;
                        } else {
                            saleReg = 0;
                        }
                    }
                    for (var i = 0; i < salesRea.length; i++) {
                        if (salesRea.length != 0) {
                            saleRea++;
                        } else {
                            saleRea = 0;
                        }
                    }
                    for (var i = 0; i < salesCan.length; i++) {
                        if (salesCan.length != 0) {
                            saleCan++;
                        } else {
                            saleCan = 0;
                        }
                    }
                    for (var i = 0; i < salesPen.length; i++) {
                        if (salesPen.length != 0) {
                            salePen++;
                        } else {
                            salePen = 0;
                        }
                    }
                    for (var i = 0; i < salesTot.length; i++) {
                        if (salesTot.length != 0) {
                            saleTot++;
                        } else {
                            saleTot = 0;
                        }
                    }
                    $("#ModalEmployees").modal("show");
                    $("#type_identification_id").val(type_identification.name);
                    $("#identification").val(user.identification);
                    $("#name").text(user.name);
                    $("#role").val(role.name);
                    $("#phone").val(user.phone);
                    $("#email").val(user.email);
                    $("#city").val(city.name);
                    $("#state").val(state.name);
                    $("#country").val(country.name);
                    $("#state_employee").val(state_employee.name);
                    $("#salesRegUser").text(saleReg);
                    $("#salesReaUser").text(saleRea);
                    $("#salesCanUser").text(saleCan);
                    $("#salesPenUser").text(salePen);
                    $("#salesTotUser").text(saleTot);

                    if (user.img !== null) {
                        $("#imageUser").attr("src", user.link + user.img);
                    } else {
                        $("#imageUser").attr(
                            "src",
                            "/adminlte/img/users/default.png"
                        );
                    }
                }
            }
        });
    }
</script>
