function registerEmployee() {
    let type_identification_id = document.getElementById(
        "type_identification_id"
    ).value;
    let identification = document.getElementById("identification").value;
    let name = document.getElementById("name").value;
    let email = document.getElementById("email").value;
    let phone = document.getElementById("phone").value;
    let role_id = document.getElementById("role_id").value;
    let country_id = document.getElementById("country_id").value;
    let state_id = document.getElementById("state_id").value;
    let city_id = document.getElementById("city_id").value;
    let password = document.getElementById("password").value;
    let passwordConfirm = document.getElementById("password-confirm").value;
    var regex = /^(?:[^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*|"[^\n"]+")@(?:[^<>()[\].,;:\s@"]+\.)+[^<>()[\]\.,;:\s@"]{2,63}$/i;

    if (
        type_identification_id == 0 ||
        type_identification_id == "" ||
        identification == 0 ||
        identification == "" ||
        name == 0 ||
        name == "" ||
        email == 0 ||
        email == "" ||
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
        if (!regex.exec(email)) {
            Swal.fire({
                title: "Correo electronico no valido",
                text: "El Correo electronico ingresado no es un formato valido",
                icon: "error",
                confirmButtonColor: "#343a40"
            });
            return false;
        } else {
            if (password.length == 0 || passwordConfirm.length == 0) {
                Swal.fire({
                    title: "Error de contraseña",
                    text: "Los campos de contraseña no pueden estar vacios",
                    icon: "error",
                    confirmButtonColor: "#343a40"
                });
                return false;
            } else {
                if (password != passwordConfirm) {
                    Swal.fire({
                        title: "Error de contraseña",
                        text: "Los campos de contraseña no coinciden",
                        icon: "error",
                        confirmButtonColor: "#343a40"
                    });

                    return false;
                } else {
                    Swal.fire({
                        title: "Estas seguro?",
                        text: "Deseas crear al usuario " + name,
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonColor: "#343a40",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Si, Crearlo!",
                        cancelButtonText: "Cancelar"
                    }).then(result => {
                        if (result.isConfirmed) {
                            let data = {
                                type_identification_id,
                                identification,
                                name,
                                email,
                                phone,
                                role_id,
                                city_id,
                                password
                            };
                            console.log(data);
                            let timerInterval;
                            Swal.fire({
                                title: "Creando empleado",
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
                                url: "/empleados/create",
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
                                                        "/empleados"
                                                    );
                                                });
                                            } else {
                                                if (r["status"] == 100) {
                                                    Swal.fire({
                                                        icon: r["icon"],
                                                        title: r["title"],
                                                        text: r["message"]
                                                    });
                                                    return false;
                                                } else {
                                                    Swal.fire({
                                                        icon: "error",
                                                        title: "Ops...",
                                                        text:
                                                            "Ocurrio un error inesperado"
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
        }
    }
}

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
