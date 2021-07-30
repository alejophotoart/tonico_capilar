var i = 0;
function trashProduct(evt) {
    i = i - 1;
    $("." + evt).remove();
}
function minTwoDigits(n) {
    return (n < 10 ? "0" : "") + n;
}
$(document).ready(function() {
    document.getElementById("name_user").readOnly = true;
    document.getElementById("role_id_user").readOnly = true;

    $("#formId input[type=checkbox]").click(function() {
        if (this.checked) {
            checkPassedOrder($(this).val());
        }
    });
    /**
     * pasa las orden que tenga deposito a deposito pendiente para logistica
     */

    $("#formPassed input[type=checkbox]").click(function() {
        if (this.checked) {
            checkProcessOrder($(this).val());
        }
    });
    /**
     * logistica pasa la ordenes de deposito aprobado a en proceso
     */

    $("#formDelivered input[type=checkbox]").click(function() {
        if (this.checked) {
            checkDeliveredOrder($(this).val());
        }
    });
    /**
     * logistica y adminis pasan las ordenes de en proceso a entregado
     */

    $("#formIdPending input[type=checkbox]").click(function() {
        if (this.checked) {
            checkPassedOrderPending($(this).val());
        }
    });
    /**
     * pasa las ordenes reagendadas que tengan deposito a depositos aprobados de logistica
     */

    $("#buttonVoucher").click(function(e) {
        e.preventDefault();
        showVoucher(order.link, order.img);
    });

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

    var datetime = new Date(); //Fecha actual
    var mes = ("0" + (datetime.getMonth() + 1)).slice(-2);
    var dia = ("0" + datetime.getDate()).slice(-2);
    var ano = datetime.getFullYear(); //obteniendo año
    var hora = datetime.getHours(); //obteniendo hora
    var minutos = datetime.getMinutes(); //obteniendo minuto

    document.getElementById("delivery_date").value =
        ano +
        "-" +
        mes +
        "-" +
        dia +
        "T" +
        minTwoDigits(hora) +
        ":" +
        minTwoDigits(minutos);

    $("select[name='payment_type_id']").change(function() {
        if ($("select[name='payment_type_id']").val() == 1) {
            $("#formFileSm").prop("hidden", true);
        }

        if ($("select[name='payment_type_id']").val() == 2) {
            $("#formFileSm").prop("hidden", false);
        }
    });
});

function validePhone(evt) {
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
            text: "El campo Telefono es solo numerico",
            confirmButtonColor: "#343a40"
        });
        return false;
    }
}
function showVoucher(link, img) {
    Swal.fire({
        imageUrl: "/" + link + img,
        imageHeight: 700,
        imageWidth: 500,
        imageAlt: "A tall image",
        confirmButtonColor: "#343a40"
    });
}

function checkPassedOrder(id) {
    Swal.fire({
        title: "Estas seguro?",
        text: "Deseas aprobar este deposito",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#343a40",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Aprobarlo!",
        cancelButtonText: "Cancelar"
    }).then(result => {
        if (result.isConfirmed) {
            let timerInterval;
            Swal.fire({
                title: "Aprobando deposito del Pedido " + id,
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
                url: "/pedidos/aprobados/" + id,
                type: "put",
                contentType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                    contentType: "application/json"
                },
                data: null,
                success: function(r) {
                    willClose: () => {
                        clearInterval(timerInterval);
                    };
                    if (r["status"] == 200) {
                        Swal.fire({
                            icon: r["icon"],
                            title: r["title"],
                            text:
                                r["message"] +
                                r["space"] +
                                r["id"] +
                                r["space"] +
                                r["message2"],
                            confirmButtonColor: "#343a40",
                            showConfirmButton: true
                        }).then(val => {
                            $(location).attr("href", "/pedidos/depositos");
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Ops...",
                            text: "Ocurrio un error inesperado"
                        });
                    }
                }
            });
        } else {
            if (result.dismiss) {
                $("#formId input[type=checkbox]").prop("checked", false);
            }
        }
    });
}

function checkProcessOrder(id){
    Swal.fire({
        title: "Estas seguro?",
        text: "Deseas Poner en proceso el pedido " + id,
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#343a40",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Procesarlo!",
        cancelButtonText: "Cancelar"
    }).then(result => {
        if (result.isConfirmed) {
            let timerInterval;
            Swal.fire({
                title: "Procesando Pedido",
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
                url: "/pedidos/proceso/" + id,
                type: "put",
                contentType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                    contentType: "application/json"
                },
                data: null,
                success: function(r) {
                    willClose: () => {
                        clearInterval(timerInterval);
                    };
                    if (r["status"] == 200) {
                        Swal.fire({
                            icon: r["icon"],
                            title: r["title"],
                            text:
                                r["message"] +
                                r["space"] +
                                r["id"] +
                                r["space"] +
                                r["message2"],
                            confirmButtonColor: "#343a40",
                            showConfirmButton: true
                        }).then(val => {
                            $(location).attr("href", "/pedidos/depositos");
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Ops...",
                            text: "Ocurrio un error inesperado"
                        });
                    }
                }
            });
        } else {
            if (result.dismiss) {
                $("#formPassed input[type=checkbox]").prop("checked", false);
            }
        }
    });
}

function checkDeliveredOrder(id){
    Swal.fire({
        title: "Estas seguro?",
        text: "Deseas marcar el pedido " + id + " como entregado?",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#343a40",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, entregado!",
        cancelButtonText: "Cancelar"
    }).then(result => {
        if (result.isConfirmed) {
            let timerInterval;
            Swal.fire({
                title: "Entregando Pedido",
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
                url: "/pedidos/entregados/" + id,
                type: "put",
                contentType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                    contentType: "application/json"
                },
                data: null,
                success: function(r) {
                    willClose: () => {
                        clearInterval(timerInterval);
                    };
                    if (r["status"] == 200) {
                        Swal.fire({
                            icon: r["icon"],
                            title: r["title"],
                            text:
                                r["message"] +
                                r["space"] +
                                r["id"] +
                                r["space"] +
                                r["message2"],
                            confirmButtonColor: "#343a40",
                            showConfirmButton: true
                        }).then(val => {
                            $(location).attr("href", "/pedidos/proceso");
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Ops...",
                            text: "Ocurrio un error inesperado"
                        });
                    }
                }
            });
        } else {
            if (result.dismiss) {
                $("#formDelivered input[type=checkbox]").prop("checked", false);
            }
        }
    });
}

function checkPassedOrderPending(id){
    Swal.fire({
        title: "Estas seguro?",
        text: "Deseas aprobar este deposito",
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#343a40",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Aprobarlo!",
        cancelButtonText: "Cancelar"
    }).then(result => {
        if (result.isConfirmed) {
            let timerInterval;
            Swal.fire({
                title: "Aprobando deposito del Pedido " + id + " reagendado",
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
                url: "/pedidos/aprobados/" + id,
                type: "put",
                contentType: "application/json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                    contentType: "application/json"
                },
                data: null,
                success: function(r) {
                    willClose: () => {
                        clearInterval(timerInterval);
                    };
                    if (r["status"] == 200) {
                        Swal.fire({
                            icon: r["icon"],
                            title: r["title"],
                            text:
                                r["message"] +
                                r["space"] +
                                r["id"] +
                                r["space"] +
                                r["message2"],
                            confirmButtonColor: "#343a40",
                            showConfirmButton: true
                        }).then(val => {
                            $(location).attr("href", "/pedidos/pendientes");
                        });
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Ops...",
                            text: "Ocurrio un error inesperado"
                        });
                    }
                }
            });
        } else {
            if (result.dismiss) {
                $("#formIdPending input[type=checkbox]").prop("checked", false);
            }
        }
    });
}
