$(document).ready(function() {
    $("#type_identification_id").prop("disabled", true);
    document.getElementById("identification").readOnly = true;
    document.getElementById("email").readOnly = true;
});
function EditEmployee(id) {
    let name = document.getElementById("name").value;
    let phone = document.getElementById("phone").value;
    let employee_state_id = document.getElementById("employee_state_id").value;
    let role_id = document.getElementById("role_id").value;
    let country_id = document.getElementById("country_id").value;
    let state_id = document.getElementById("state_id").value;
    let city_id = document.getElementById("city_id").value;

    if (
        name == 0 ||
        name == "" ||
        phone == 0 ||
        phone == "" ||
        employee_state_id == 0 ||
        employee_state_id == "" ||
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
            text: "Deseas editar al usuario " + name,
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
                    employee_state_id,
                    role_id,
                    city_id
                };
                console.log(data);
                let timerInterval;
                Swal.fire({
                    title: "Actualizando informacion del empleado",
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
                    url: "/empleados/" + id + "/update",
                    type: "PUT",
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
                                        confirmButtonColor: "#343a40",
                                        showConfirmButton: true
                                    }).then(val => {
                                        $(location).attr("href", "/empleados");
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
        });
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
