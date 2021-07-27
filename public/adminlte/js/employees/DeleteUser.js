function DeleteUser(id, name) {
    Swal.fire({
        title: "Estas seguro?",
        text: "Quieres eliminar a " + name,
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#343a40",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, eliminarlo!",
        cancelButtonText: "Cancelar"
    }).then(result => {
        if (result.isConfirmed) {
            let timerInterval;
            Swal.fire({
                title: "Elimando empleado",
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
                url: "/empleados/" + id + "/" + name + "/delete",
                type: "DELETE",
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
                            text: r["message"] + r["space"] + r["name"],
                            confirmButtonColor: "#343a40",
                            showConfirmButton: true
                        }).then(val => {
                            $(location).attr("href", "/empleados");
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
