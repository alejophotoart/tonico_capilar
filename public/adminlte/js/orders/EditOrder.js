var i = 0;
function trashProduct(evt){
    console.log(evt);
    i = i - 1;
    $("." + evt).remove();
}
$(document).ready(function() {
    document.getElementById("identification").readOnly = true;
    document.getElementById("notes").readOnly = true;
    document.getElementById("delivery_date_info").readOnly = true;

    $("#addProduct").click(function(e) {
        e.preventDefault(); //eliminamos el evento por defecto
        if (i >= 9) {
            Swal.fire({
                icon: "warning",
                title: "Ops...",
                text: "Se permite maximo 10 grupos de items",
                confirmButtonColor: "#343a40"
            });
            return false;
        } else {
            i++;

            let elem = $("#ShowMoreProduct")
                .clone()
                .appendTo(".fieldGroupCopy")
                .attr("class", "input-group mb-3 copy-" + i)
                .attr("id", "copy");

            let element = document.querySelector(".copy-" + i);
            element.style.setProperty("display", "flex");
            elem.children()[2].children[0].value = "copy-" + i;
            elem.children()[1].className =
                "form-control col-md-11 custom-select copy";
            elem.children()[0].className = "form-control copy_quantity";

            return true;
        }
    });

});

function minTwoDigits(n) {
    return (n < 10 ? "0" : "") + n;
}

function EditOrder(id, client_id, address_id, user_id, delivery_d){

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
    if($("#delivery_date").val() == "" || $("#delivery_date").val() == null || $("#delivery_date").val() == undefined){
        var delivery_date = delivery_d;
    }else{
        var delivery_date = document.getElementById("delivery_date").value;
        var reason = document.getElementById("reason").value;
    }
    let notes = document.getElementById("notes").value;
    let total2 = document.getElementById("total").value;
    // let delivery_price2 = document.getElementById("delivery_price").value;
    let img = document.getElementById("LoadVoucher").value;
    let quantity = [];
    let product = [];

    for (var i = 0; i < $(".copy_quantity").length; i++) {
        quantity.push($(".copy_quantity")[i].value);
    }
    for (var i = 0; i < $(".copy").length; i++) {
        product.push($(".copy")[i].value);
    }
    var prod_quan = [quantity, product];
    let total1 = total2.replace(/\$/g, "");
    let total = total1.replace(/\./g, "");
    console.log(prod_quan);
    // let delivery_price1 = delivery_price2.replace(/\$/g, "");
    // let delivery_price = delivery_price1.replace(/\./g, "");

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

    for (let i = 0; i < product.length; i++) {
        if (
            product[i].length <= 0 ||
            product[i].length == ""
        ) {
            Swal.fire({
                icon: "warning",
                title: "Productos",
                text: "Debes agregar como minimo 1 producto",
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
        Swal.fire({
            title: "Estas seguro?",
            text: "Deseas actualizar este nuevo pedido",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#343a40",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, Actualizarlo!",
            cancelButtonText: "Cancelar"
        }).then(result => {
            if (result.isConfirmed) {
                let data = {
                    id,
                    client_id,
                    address_id,
                    user_id,
                    identification,
                    name,
                    address,
                    neighborhood,
                    phone,
                    whatsapp,
                    payment_type_id,
                    delivery_date,
                    reason,
                    notes,
                    prod_quan,
                    total,
                    city_id
                };
                console.log(data);
                let timerInterval;
                Swal.fire({
                    title: "Actualizando Pedido",
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
                    url: "/pedidos/editar/" + id,
                    type: "PUT",
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
                        if (r["status"] == 400) {
                            Swal.fire({
                                icon: r["icon"],
                                title: r["title"],
                                text: r["message"],
                                confirmButtonColor: "#343a40",
                                showConfirmButton: true
                            });
                            return false;
                        } else {
                            var image = document.getElementById("LoadVoucher");
                            image = image.files[0];
                            if (image) {
                                var id_order = r.id;
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
                    }
                });
            }
        });
    }
}

function saveImage(id, name) {
    var fImage = document.getElementById("LoadVoucher");
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
                        if (val.value) {
                            $(location).attr("href", "/pedidos");
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


function limitar(e, contenido, caracteres) {
    var unicode = e.keyCode ? e.keyCode : e.charCode;
    if (
        unicode == 8 ||
        unicode == 46 ||
        unicode == 37 ||
        unicode == 39 ||
        unicode == 38 ||
        unicode == 40
    ) {
        return true;
    } // Si ha superado el limite de caracteres devolvemos false
    if (contenido.length >= caracteres) {
        Swal.fire({
            icon: "error",
            title: "Ops...",
            text: "Supero el limite de caracteres",
            confirmButtonColor: "#343a40"
        });

        return false;
    }
}
