function deleteProductWarehouse(e, t, o, i) {
    Swal.fire({
        title: "Estas seguro?",
        text: "Quieres eliminar el producto " + o + " de la bodega " + t,
        icon: "question",
        showCancelButton: !0,
        confirmButtonColor: "#343a40",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminarlo!",
        cancelButtonText: "Cancelar",
    }).then((n) => {
        if (n.isConfirmed) {
            let n;
            Swal.fire({
                title: "Eliminado " + o + " de " + t,
                didOpen: () => {
                    Swal.showLoading(),
                        (n = setInterval(() => {
                            const e = Swal.getHtmlContainer();
                            if (e) {
                                const t = e.querySelector("b");
                                t && (t.textContent = Swal.getTimerLeft());
                            }
                        }, 100));
                },
            }),
                $.ajax({
                    url: "/productos-bodegas/" + e + "/" + o + "/" + t + "/" + i + "/delete",
                    type: "DELETE",
                    contentType: "application/json",
                    headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"), contentType: "application/json" },
                    data: null,
                    success: function (e) {
                        console.log(e),
                            200 == e.status
                                ? Swal.fire({ icon: e.icon, title: e.title, text: e.message + e.space + e.name + e.space + e.message2 + e.space + e.name2, confirmButtonColor: "#343a40", showConfirmButton: !0 }).then((e) => {
                                      $(location).attr("href", "/productos-bodega");
                                  })
                                : Swal.fire({ icon: "error", title: "Ops...", text: "Ocurrio un error inesperado" });
                    },
                });
        }
    });
}
