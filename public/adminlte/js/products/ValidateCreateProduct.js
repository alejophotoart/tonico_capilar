$(function () {
    $('#warehouses').selectpicker();
});
function registerProduct() {
    let code = document.getElementById("code").value;
    let name = document.getElementById("name").value;
    let price2 = $("#price").val();
    let quantity = document.getElementById("quantity").value;
    let description = document.getElementById("description").value;
    var warehouses = $("#warehouses").val();

    let price1 = price2.replace(/\$/g, "");
    let price = price1.replace(/\./g, "");

    if (
        code == 0 ||
        code == "" ||
        name == 0 ||
        name == "" ||
        price == 0 ||
        price == "" ||
        quantity == 0 ||
        quantity == ""||
        warehouses == 0 ||
        warehouses == ""
    ) {
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
            text: "Deseas crear el producto " + name,
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#343a40",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, Crearlo!",
            cancelButtonText: "Cancelar"
        }).then(result => {
            if (result.isConfirmed) {
                let data = {
                    code,
                    name,
                    price,
                    quantity,
                    description,
                    warehouses
                };
                console.log(data);
                let timerInterval;
                Swal.fire({
                    title: "Creando Producto",
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
                    url: "/productos/create",
                    type: "POST",
                    data: JSON.stringify(data),
                    contentType: "application/json",
                    dataType: "json",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        )
                    },
                    //data: obj.json.strin,
                    success: function(r) {
                        willClose: () => {
                            clearInterval(timerInterval);
                        };
                        var image = document.getElementById("formFile");
                        image = image.files[0];
                        if (r["status"] == 500) {
                            Swal.fire({
                                icon: r["icon"],
                                title: r["title"],
                                text: r["message"],
                                confirmButtonColor: "#343a40",
                                showConfirmButton: true
                            });
                            return false;
                        } else {
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
                                if (image) {
                                    var id_product = r.d.code;
                                    var name_product = r.name;
                                    saveImage(id_product, name_product);
                                } else {
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
                                                "/productos"
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
                            }
                        }
                    }
                });
            }
        });
    }
}

function saveImage(code, name) {
    var fImage = document.getElementById("formFile");
    fImage = fImage.files[0];
    console.log(fImage);
    let timerInterval;
    Swal.fire({
        title: "Validando Imagen",
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
        formData.append("code", code);
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
            url: "/productos/saveImage",
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
                            console.log(
                                "hola esta mierda sirve pa guardar la imagen de mierda"
                            );
                            $(location).attr("href", url + "/productos");
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

function valideKey(evt) {
    // code is the decimal ASCII representation of the pressed key.
    var code = evt.which ? evt.which : evt.keyCode;

    if (code == 8) {
        // backspace.
        return true;
    } else if (code >= 48 && code <= 57) {
        // is a number.
        return true;
    } else {
        // other keys.
        Swal.fire({
            icon: "warning",
            title: "Ops...",
            text: "El campo Codigo es solo numerico",
            confirmButtonColor: "#343a40"
        });
        return false;
    }
}

function validePrice(evt) {
    // code is the decimal ASCII representation of the pressed key.
    var code = evt.which ? evt.which : evt.keyCode;

    if (code == 8) {
        // backspace.
        return true;
    } else if (code >= 48 && code <= 57) {
        // is a number.
        return true;
    } else {
        // other keys.
        Swal.fire({
            icon: "warning",
            title: "Ops...",
            text: "El campo Precio es solo numerico",
            confirmButtonColor: "#343a40"
        });
        return false;
    }
}

function validequantity(evt) {
    // code is the decimal ASCII representation of the pressed key.
    var code = evt.which ? evt.which : evt.keyCode;

    if (code == 8) {
        // backspace.
        return true;
    } else if (code >= 48 && code <= 57) {
        // is a number.
        return true;
    } else {
        // other keys.
        Swal.fire({
            icon: "warning",
            title: "Ops...",
            text: "El campo Cantidad es solo numerico",
            confirmButtonColor: "#343a40"
        });
        return false;
    }
}
