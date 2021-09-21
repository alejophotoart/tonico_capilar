function editProductWarehouse(t) {
    $.ajax({
        url: "/productos-bodega/" + t,
        type: "GET",
        contentType: "application/json",
        headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"), contentType: "application/json" },
        success: function (t) {
            console.log(t);
            var e = t,
                m = t.products,
                o = t.warehouses;
            t &&
                ($("#editModalProductWarehouse").modal("show"),
                $("#space").text(' - '),

                o.forEach((t) => {
                    $("#name_productWarehouse").text(t.name);
                }),
                m.forEach((t) => {
                    $("#name_product").text(t.name);
                }),
                $("#updateQuantity").data("id", e.id),
                $("#updateQuantity").data("product_id", e.product_id),
                $("#updateQuantity").data("warehouse_id", e.warehouse_id));

        },
    });
}
function editQuantity() {
    var t = $("#updateQuantity").data("product_id"),
        e = $("#updateQuantity").data("id"),
        w = $("#updateQuantity").data("warehouse_id"),
        o = document.getElementById("name_productWarehouse").innerHTML;
    let a = document.getElementById("quantity").value;
    if (0 == a || "" == a) return Swal.fire({ icon: "info", title: "Campos vacios", text: "Existen campos vacios, por favor llenelos", confirmButtonColor: "#343a40", showConfirmButton: !0 }), !1;
    Swal.fire({
        title: "Estas seguro?",
        text: "Deseas editar la cantidad de la bodega " + o,
        icon: "question",
        showCancelButton: !0,
        confirmButtonColor: "#343a40",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Editarlo!",
        cancelButtonText: "Cancelar",
    }).then((n) => {
        if (n.isConfirmed) {
            let n,
                i = { quantity: a, name: o, product_id_pw: t , warehouse_id_pw: w};
            Swal.fire({
                title: "Actualizando Bodega",
                didOpen: () => {
                    Swal.showLoading(),
                        (n = setInterval(() => {
                            const t = Swal.getHtmlContainer();
                            if (t) {
                                const e = t.querySelector("b");
                                e && (e.textContent = Swal.getTimerLeft());
                            }
                        }, 100));
                },
            }),
                $.ajax({
                    url: "/productos-bodega/" + e + "/update",
                    type: "PUT",
                    data: JSON.stringify(i),
                    contentType: "application/json",
                    dataType: "json",
                    headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content") },
                    success: function (r) {
                        willClose: () => {
                            clearInterval(timerInterval);
                        };
                        if(r["status"] == 400){
                            Swal.fire({
                                icon: r["icon"],
                                title: r["title"],
                                text: r["message"],
                                confirmButtonColor: "#343a40"
                            });
                            return false;
                        }else{
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
                },
            });
        }
    });
}
