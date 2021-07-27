function authenticated() {
    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;
    let remember = document.getElementById("remember").value;
    var regex = /^(?:[^<>()[\].,;:\s@"]+(\.[^<>()[\].,;:\s@"]+)*|"[^\n"]+")@(?:[^<>()[\].,;:\s@"]+\.)+[^<>()[\]\.,;:\s@"]{2,63}$/i;

    if (email == 0 || email == "" || password == 0 || password == "") {
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
            let data = {
                email,
                password,
                remember
            };
            $.ajax({
                url: "/authenticate",
                type: "POST",
                data: JSON.stringify(data),
                contentType: "application/json",
                dataType: "json",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                //data: obj.json.strin,
                success: function(r) {
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
                            if (r["status"] == 200) {
                                Swal.fire({
                                    position: "top-end",
                                    icon: r["icon"],
                                    title: r["title"],
                                    showConfirmButton: true
                                }).then(val => {
                                    $(location).attr("href", "/home");
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
                                        text: "Ocurrio un error inesperado"
                                    });
                                    return false;
                                }
                            }
                        }
                    }
                }
            });
        }
    }
}
