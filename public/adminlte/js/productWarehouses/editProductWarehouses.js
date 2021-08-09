function editProductWarehouse(id){
    $.ajax({
        url: "/productos-bodega/" + id,
        type: "GET",
        contentType: "application/json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            contentType: "application/json"
        },
        success: function(r) {
            console.log(r);
            var prodcutWarehouse = r;
            var p_w = r.warehouses;

            if(r){
                $("#editModalProductWarehouse").modal("show");
                $("#quantity").val(prodcutWarehouse.quantity);
                p_w.forEach(pw => {
                    $("#name_productWarehouse").text(pw.name);
                });
                $("#updateQuantity").data("id", prodcutWarehouse.id);
                $("#updateQuantity").data("product_id", prodcutWarehouse.product_id);
            }
        }
    });
}

function editQuantity() {
    var product_id_pw = $("#updateQuantity").data("product_id");
    var id_pw = $("#updateQuantity").data("id");
    var name = document.getElementById("name_productWarehouse").innerHTML;

    let quantity = document.getElementById("quantity").value;
    if (quantity == 0 || quantity == "") {
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
            text: "Deseas editar la cantidad de la bodega " + name,
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#343a40",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, Editarlo!",
            cancelButtonText: "Cancelar"
        }).then(result => {
            if (result.isConfirmed) {
                let data = {
                    quantity,
                    name,
                    product_id_pw
                };
                let timerInterval;
                Swal.fire({
                    title: "Actualizando Bodega",
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
                    url: "/productos-bodega/" + id_pw + "/update",
                    type: "PUT",
                    data: JSON.stringify(data),
                    contentType: "application/json",
                    dataType: "json",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                            "content"
                        )
                    },
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
                                    r["name"],
                                confirmButtonColor: "#343a40",
                                showConfirmButton: true
                            }).then(val => {
                                var url = "http://127.0.0.1:8000";
                                if (val.value) {
                                    $(location).attr(
                                        "href",
                                        url + "/productos-bodega"
                                    );
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
