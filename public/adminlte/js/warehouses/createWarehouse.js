function ShowCreateWarehouse(){
    $.ajax({
        url: "/bodegas/crear",
        type: "GET",
        contentType: "application/json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            contentType: "application/json"
        },
        success: function(r) {
            country = r;
            if(r){
                $("#country_id option").remove();
                $("#country_id").append(
                    '<option value="0" selected disabled>Pais donde se guardara este producto</option>'
                );
                for (var i = 0; i < country.length; i++) {
                    $("#country_id").append(
                        '<option value="' +
                            country[i].id +
                            '">' +
                            country[i].name +
                            "</option>"
                    );
                }
                $('#country_id').selectpicker('refresh');
                $('#country_id').selectpicker('render');

                $("#CreateWarehouseModal").modal("show");
            }
        }
    });
}

function createWarehouse(){
    let name = document.getElementById("name").value;
    let city_id = document.getElementById("city_id").value;
    if (
        country_id == 0 ||
        country_id == "" ||
        state_id == 0 ||
        state_id == "" ||
        city_id == 0 ||
        city_id == ""
    ) {
        console.log();
        Swal.fire({
            icon: "info",
            title: "Campos vacios",
            text: "Existen campos vacios, por favor llenelos",
            confirmButtonColor: "#343a40",
            showConfirmButton: true
        });
        return false;
    } else {
        Swal.fire({
            title: "Estas seguro?",
            text: "Deseas crear la bodega " + name,
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#343a40",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, Crearla!",
            cancelButtonText: "Cancelar"
        }).then(result => {
            if (result.isConfirmed) {
                let data = {
                    name,
                    city_id
                };
                console.log(data);
                let timerInterval;
                Swal.fire({
                    title: "Creando bodega",
                        didOpen: () => {
                            Swal.showLoading();
                                timerInterval = setInterval(() => {
                                    const content = Swal.getHtmlContainer();
                                    if (content) {
                                        const b = content.querySelector(
                                            "b"
                                        );
                                    if (b) {
                                        b.textContent = Swal.getTimerLeft();
                                    }
                                }
                            }, 100);
                        }
                    });
                $.ajax({
                    url: "/bodegas/create",
                    type: "POST",
                    data: JSON.stringify(data),
                    contentType: "application/json",
                    dataType: "json",
                    headers: {
                        "X-CSRF-TOKEN": $(
                            'meta[name="csrf-token"]'
                        ).attr("content")
                    },
                    //data: obj.json.strin,
                    success: function(r) {
                        if (r["status"] == 200) {
                            Swal.fire({
                                icon: r["icon"],
                                title: r["title"],
                                text:
                                    r["message"] +
                                    r["space"] +
                                    r["name"],
                                confirmButtonColor: "#343a40",
                                showConfirmButton: true
                            }).then(val => {
                                $(location).attr(
                                    "href",
                                    "/bodegas"
                                );
                            });
                        } else {
                            if (r["status"] == 100) {
                                Swal.fire({
                                    icon: r["icon"],
                                    title: r["title"],
                                    text: r["message"],
                                    confirmButtonColor: "#343a40"
                                });
                                return false;
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Ops...",
                                    text:
                                        "Ocurrio un error inesperado",
                                    confirmButtonColor: "#343a40"
                                });
                                return false;
                            }
                        }
                    }
                });
            }
        });
    }
}
