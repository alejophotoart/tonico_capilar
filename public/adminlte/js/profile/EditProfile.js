function EditProfile(id, nombre) {
    let name = document.getElementById("nombre").value;
    let phone = document.getElementById("telefono").value;
    let role_id = document.getElementById("rol").value;
    let country_id = document.getElementById("pais").value;
    let state_id = document.getElementById("estado").value;
    let city_id = document.getElementById("ciudad").value;

    if (
        name == 0 ||
        name == "" ||
        phone == 0 ||
        phone == "" ||
        role_id == 0 ||
        role_id == "" ||
        country_id == 0 ||
        country_id == "" ||
        state_id == 0 ||
        state_id == "" ||
        city_id == 0 ||
        city_id == ""
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
            text: "Deseas editar tu informacion " + nombre,
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#343a40",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, Editarlo!",
            cancelButtonText: "Cancelar"
        }).then(result => {
            if (result.isConfirmed) {
                let data = {
                    name,
                    phone,
                    role_id,
                    city_id
                };
                let timerInterval;
                Swal.fire({
                    title: "Actualizando Perfil",
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
                    url: "/profile/" + id + "/update",
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
                        var role = r.d.role;
                        var id_profile = r.d.id;
                        var name_profile = r.name;
                        var image = document.getElementById("imgprofile");
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
                                    updateImageProfile(
                                        id_profile,
                                        name_profile
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
                                            confirmButtonColor: "#343a40",
                                            showConfirmButton: true
                                        }).then(val => {
                                            var url = "http://127.0.0.1:8000";
                                            if (val.value) {
                                                if (role == 1 || role == 2) {
                                                    $(location).attr(
                                                        "href",
                                                        url + "/resumen"
                                                    );
                                                } else {
                                                    if (
                                                        role == 3 ||
                                                        role == 4
                                                    ) {
                                                        $(location).attr(
                                                            "href",
                                                            url + "/pedidos"
                                                        );
                                                    }
                                                }
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
                            }
                        }
                    }
                });
            }
        });
    }
}

function updateImageProfile(id, name) {
    var fImage = document.getElementById("imgprofile");
    fImage = fImage.files[0];
    let timerInterval;
    Swal.fire({
        title: "Validando imagen de perfil",
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
            url: "/profile/updateImageProfile",
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
                            $(location).attr("href", url + "/resumen");
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
