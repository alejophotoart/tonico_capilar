function CreateOrder(id) {
    //for (var i = 0; i < $(".product_copy")[i].value.length; i++) {}

    let identification = document.getElementById("identification").value;
    let name = document.getElementById("name").value;
    let address = document.getElementById("address").value;
    let neighborhood = document.getElementById("neighborhood").value;
    let phone = document.getElementById("phone").value;
    let whatsapp = document.getElementById("whatsapp").value;
    let country_id = document.getElementById("country_id").value;
    let state_id = document.getElementById("state_id").value;
    let city_id = document.getElementById("city_id").value;
    let payment_type_id = document.getElementById("payment_type_id").value;
    let delivery_date = document.getElementById("delivery_date").value;
    let notes = document.getElementById("notes").value;
    let total2 = document.getElementById("total").value;
    let delivery_price2 = document.getElementById("delivery_price").value;
    let img = document.getElementById("formFileSm").value;
    let tramp = document.getElementById("trampId").value;
    let quantity = [];
    let product = [];
    for (var i = 0; i < $(".copy_quantity").length; i++) {
        quantity.push($(".copy_quantity")[i].value);
    }
    for (var i = 0; i < $(".copy").length; i++) {
        product.push($(".copy")[i].value);
    }
    var prod_quan = [quantity, product];
    console.log(tramp);

    let total1 = total2.replace(/\$/g, "");
    let total = total1.replace(/\./g, "");
    let delivery_price1 = delivery_price2.replace(/\$/g, "");
    let delivery_price = delivery_price1.replace(/\./g, "");

    if ($("select[name='payment_type_id']").val() == 2) {
        if (img == null || img == "") {
            Swal.fire({
                icon: "warning",
                title: "Comprobante de pago",
                text: "por favor adjunte el comprobrante del deposito",
                confirmButtonColor: "#343a40"
            });
            return false;
        }
    }

    for (var c = 0; c < $(".copy_quantity").length; c++) {
        if (
            $(".copy_quantity")[c].value <= 0 ||
            $(".copy_quantity")[c].value == ""
        ) {
            Swal.fire({
                icon: "warning",
                title: "Cantidad",
                text: "La cantidad digitada no es valida",
                confirmButtonColor: "#343a40"
            });
            return false;
        }
    }

    if (
        identification == 0 ||
        identification == "" ||
        name == 0 ||
        name == "" ||
        address == 0 ||
        address == "" ||
        phone == 0 ||
        phone == "" ||
        neighborhood == 0 ||
        neighborhood == "" ||
        whatsapp == 0 ||
        whatsapp == "" ||
        delivery_date == 0 ||
        delivery_date == "" ||
        total == 0 ||
        total == "" ||
        payment_type_id == 0 ||
        payment_type_id == "" ||
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
        let timerInterval;
        Swal.fire({
            title: "Validando cliente",
            didOpen: () => {
                Swal.showLoading();

                timerInterval = setInterval(() => {
                    const content = Swal.getHtmlContainer();
                    if (content) {
                        const b = content.querySelector("b");
                        if (b) {
                            b.textContent = Swal.getTimerLeft();
                        }
                    }
                }, 100);
            }
        });
        $.ajax({
            url: "/pedidos/" + identification + "/search",
            type: "GET",
            contentType: "application/json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                contentType: "application/json"
            },
            success: function(r) {
                willClose: () => {
                    clearInterval(timerInterval);
                };
                console.log(r);
                if (r["status"] == 200) {
                    Swal.fire({
                        title: "Cliente existente",
                        text:
                            "El cliente de este pedido ya existe ¡¿quieres sobreescribir los datos?!",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#343a40",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Si, Sobreescribir!",
                        cancelButtonText: "Cancelar"
                    }).then(result => {
                        if (result.isConfirmed) {
                            if (r.d) {
                                $("#name").val(r.d.client_data.name);
                                $("#phone").val(r.d.client_data.phone);
                                $("#whatsapp").val(r.d.client_data.whatsapp);
                                $("#trampId").val(r.d.client_data.id);
                            }
                            Swal.fire({
                                title: "Estas seguro?",
                                text: "Deseas crear este nuevo pedido",
                                icon: "question",
                                showCancelButton: true,
                                confirmButtonColor: "#343a40",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "Si, Crearlo!",
                                cancelButtonText: "Cancelar"
                            }).then(result => {
                                if (result.isConfirmed) {
                                    let data = {
                                        id,
                                        tramp,
                                        identification,
                                        name,
                                        address,
                                        neighborhood,
                                        phone,
                                        whatsapp,
                                        payment_type_id,
                                        delivery_date,
                                        notes,
                                        prod_quan,
                                        total,
                                        delivery_price,
                                        city_id
                                    };
                                    console.log(data);
                                    let timerInterval;
                                    Swal.fire({
                                        title: "Creando Pedido",
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
                                        url: "/pedidos/create",
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
                                            willClose: () => {
                                                clearInterval(timerInterval);
                                            };
                                            var image = document.getElementById(
                                                "formFileSm"
                                            );
                                            image = image.files[0];
                                            if (image) {
                                                var id_order = r.d.id;
                                                var name_client = r.name;
                                                saveImage(
                                                    id_order,
                                                    name_client
                                                );
                                            } else {
                                                if (r["status"] == 200) {
                                                    Swal.fire({
                                                        icon: r["icon"],
                                                        title: r["title"],
                                                        text:
                                                            r["message"] +
                                                            r["space"] +
                                                            r["name"],
                                                        confirmButtonColor:
                                                            "#343a40",
                                                        showConfirmButton: true
                                                    }).then(val => {
                                                        $(location).attr(
                                                            "href",
                                                            "/pedidos"
                                                        );
                                                    });
                                                } else {
                                                    if (r["status"] == 100) {
                                                        Swal.fire({
                                                            icon: r["icon"],
                                                            title: r["title"],
                                                            text: r["message"],
                                                            confirmButtonColor:
                                                                "#343a40"
                                                        });
                                                        return false;
                                                    } else {
                                                        Swal.fire({
                                                            icon: "error",
                                                            title: "Ops...",
                                                            text:
                                                                "Ocurrio un error inesperado",
                                                            confirmButtonColor:
                                                                "#343a40"
                                                        });
                                                        return false;
                                                    }
                                                }
                                            }
                                        }
                                    });
                                }
                            });
                        } else {
                            if (result.dismiss) {
                                Swal.fire({
                                    icon: "info",
                                    title: "Ops...",
                                    text:
                                        "Si quieres realizar este pedido, debe ser un cliente inexistente",
                                    confirmButtonColor: "#343a40"
                                });
                                return false;
                            }
                        }
                    });
                } else {
                    if (r["status"] == 100) {
                        Swal.fire({
                            title: "Estas seguro?",
                            text: "Deseas crear este nuevo pedido",
                            icon: "question",
                            showCancelButton: true,
                            confirmButtonColor: "#343a40",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Si, Crearlo!",
                            cancelButtonText: "Cancelar"
                        }).then(result => {
                            if (result.isConfirmed) {
                                let data = {
                                    id,
                                    tramp,
                                    identification,
                                    name,
                                    address,
                                    neighborhood,
                                    phone,
                                    whatsapp,
                                    payment_type_id,
                                    delivery_date,
                                    notes,
                                    prod_quan,
                                    total,
                                    delivery_price,
                                    city_id
                                };
                                console.log(data);
                                let timerInterval;
                                Swal.fire({
                                    title: "Creando Pedido",
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
                                    url: "/pedidos/create",
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
                                        willClose: () => {
                                            clearInterval(timerInterval);
                                        };
                                        var image = document.getElementById(
                                            "formFileSm"
                                        );
                                        image = image.files[0];
                                        if (image) {
                                            var id_order = r.d.id;
                                            var name_client = r.name;
                                            saveImage(id_order, name_client);
                                        } else {
                                            if (r["status"] == 200) {
                                                Swal.fire({
                                                    icon: r["icon"],
                                                    title: r["title"],
                                                    text:
                                                        r["message"] +
                                                        r["space"] +
                                                        r["name"],
                                                    confirmButtonColor:
                                                        "#343a40",
                                                    showConfirmButton: true
                                                }).then(val => {
                                                    $(location).attr(
                                                        "href",
                                                        "/pedidos"
                                                    );
                                                });
                                            } else {
                                                if (r["status"] == 100) {
                                                    Swal.fire({
                                                        icon: r["icon"],
                                                        title: r["title"],
                                                        text: r["message"],
                                                        confirmButtonColor:
                                                            "#343a40"
                                                    });
                                                    return false;
                                                } else {
                                                    Swal.fire({
                                                        icon: "error",
                                                        title: "Ops...",
                                                        text:
                                                            "Ocurrio un error inesperado",
                                                        confirmButtonColor:
                                                            "#343a40"
                                                    });
                                                    return false;
                                                }
                                            }
                                        }
                                    }
                                });
                            }
                        });
                    }
                }
            }
        });
    }
}

function saveImage(id, name) {
    var fImage = document.getElementById("formFileSm");
    fImage = fImage.files[0];
    let timerInterval;
    Swal.fire({
        title: "Validando comprobante",
        didOpen: () => {
            Swal.showLoading();

            timerInterval = setInterval(() => {
                const content = Swal.getHtmlContainer();
                if (content) {
                    const b = content.querySelector("b");
                    if (b) {
                        b.textContent = Swal.getTimerLeft();
                    }
                }
            }, 100);
        }
    });
    if (fImage) {
        var formData = new FormData();
        formData.append("id", id);
        formData.append("name", name);
        formData.append("image", fImage);

        $.ajax({
            type: "POST",
            dataType: "json",
            processData: false,
            contentType: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            data: formData,
            url: "/order/saveImage",
            success: function(r) {
                willClose: () => {
                    clearInterval(timerInterval);
                };
                if (r["status"] == 200) {
                    Swal.fire({
                        icon: r["icon"],
                        title: r["title"],
                        text: r["message"] + r["space"] + r["name"],
                        confirmButtonColor: "#343a40",
                        showConfirmButton: true
                    }).then(val => {
                        var url = "http://127.0.0.1:8000";

                        if (val.value) {
                            $(location).attr("href", url + "/pedidos");
                        }
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
                            text: "Ocurrio un error inesperado",
                            confirmButtonColor: "#343a40"
                        });
                        return false;
                    }
                }
            }
        });
    } else {
        alert("No hay archivo.");
    }
}

function searchClient() {
    client_identificacion = document.getElementById("identification").value;
    if (client_identificacion == "" || client_identificacion == 0) {
        Swal.fire({
            icon: "error",
            title: "Ops...",
            text: "Escriba una identificacion valida",
            confirmButtonColor: "#343a40"
        });
        return false;
    } else {
        let timerInterval;
        Swal.fire({
            title: "Buscando Cliente",
            didOpen: () => {
                Swal.showLoading();

                timerInterval = setInterval(() => {
                    const content = Swal.getHtmlContainer();
                    if (content) {
                        const b = content.querySelector("b");
                        if (b) {
                            b.textContent = Swal.getTimerLeft();
                        }
                    }
                }, 100);
            }
        });
        $.ajax({
            url: "/pedidos/" + client_identificacion + "/search",
            type: "GET",
            contentType: "application/json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                contentType: "application/json"
            },
            success: function(r) {
                willClose: () => {
                    clearInterval(timerInterval);
                };
                if (r["status"] == 200) {
                    Swal.fire({
                        icon: r["icon"],
                        title: r["title"],
                        text: r["message"] + r["space"] + r["name"],
                        confirmButtonColor: "#343a40",
                        showConfirmButton: true
                    }).then(val => {
                        if (r.d) {
                            console.log(r.d);
                            $("#name").val(r.d.client_data.name);
                            $("#phone").val(r.d.client_data.phone);
                            $("#whatsapp").val(r.d.client_data.whatsapp);
                            $("#trampId").val(r.d.client_data.id);
                        }
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
                    }
                }
            }
        });
    }
}
