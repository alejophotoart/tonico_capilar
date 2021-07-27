async function CancelOrder(id) {
    try {
        const { value: note } = await Swal.fire({
            title: "Por que se cancela el pedido?",
            input: "textarea",
            inputLabel: "Mensaje",
            inputPlaceholder: "Escriba un mensaje...",
            inputAttributes: {
                "aria-label": "Escriba un motivo",
                maxlength: 180,
                autocapitalize: "off"
            },
            showCancelButton: true,
            cancelButtonText: "Cancelar",
            confirmButtonText: "Ok",
            confirmButtonColor: "#343a40",
            cancelButtonColor: "#d33"
        });
        if (note) {
            Swal.fire({
                title: "Estas seguro?",
                text: "Quieres cancelar la order " + id,
                icon: "question",
                showCancelButton: true,
                confirmButtonColor: "#343a40",
                cancelButtonColor: "#d33",
                confirmButtonText: "Si, cancelarlo!",
                cancelButtonText: "No, cerrar"
            }).then(result => {
                if (result.isConfirmed) {
                    let timerInterval;
                    Swal.fire({
                        title: "Cancelando Pedido",
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
                        url: "/pedidos/" + id + "/" + note + "/delete",
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
                                    text: r["message"] + r["space"] + r["id"],
                                    confirmButtonColor: "#343a40",
                                    showConfirmButton: true
                                }).then(val => {
                                    $(location).attr("href", "/pedidos");
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
                }
            });
        }
    } catch (e) {
        console.log("error:", e);
        return false;
    }
}
