$(document).ready(function() {
    $("#type_id").prop("disabled", true);
    document.getElementById("identificacion").readOnly = true;
    document.getElementById("correo").readOnly = true;
});

function ShowModalProfile(id, role_id, country_id) {
    if (role_id == 4 || role_id == 3) {
        $("#rol").prop("disabled", true);
    }
    $.ajax({
        url: "/profile/" + id,
        type: "GET",
        contentType: "application/json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            contentType: "application/json"
        },
        success: function(r) {
            console.log(r);
            var saleReg = 0;
            var saleRea = 0;
            var saleCan = 0;
            var salePen = 0;
            var saleTot = 0;

            profile = r[0][0];
            type_id = r[0][0].type_identification;
            role = r[1];
            country = r[2];
            salesReg = r[3];
            salesRea = r[4];
            salesCan = r[5];
            salesPen = r[6];
            salesTot = r[7];

            if (r) {
                for (var i = 0; i < salesReg.length; i++) {
                    if (salesReg.length != 0) {
                        saleReg++;
                    } else {
                        saleReg = 0;
                    }
                }
                for (var i = 0; i < salesRea.length; i++) {
                    if (salesRea.length != 0) {
                        saleRea++;
                    } else {
                        saleRea = 0;
                    }
                }
                for (var i = 0; i < salesCan.length; i++) {
                    if (salesCan.length != 0) {
                        saleCan++;
                    } else {
                        saleCan = 0;
                    }
                }
                for (var i = 0; i < salesPen.length; i++) {
                    if (salesPen.length != 0) {
                        salePen++;
                    } else {
                        salePen = 0;
                    }
                }
                for (var i = 0; i < salesTot.length; i++) {
                    if (salesTot.length != 0) {
                        saleTot++;
                    } else {
                        saleTot = 0;
                    }
                }

                $("#profileModal").modal("show");
                $("#pais option").remove();
                $("#rol option").remove();
                for (var i = 0; i < role.length; i++) {
                    if (role_id == role[i].id) {
                        $("#rol").append(
                            '<option value="' +
                                role[i].id +
                                '" selected>' +
                                role[i].name +
                                "</option>"
                        );
                    } else {
                        $("#rol").append(
                            '<option value="' +
                                role[i].id +
                                '">' +
                                role[i].name +
                                "</option>"
                        );
                    }
                }
                for (var i = 0; i < country.length; i++) {
                    if (country_id == country[i].id) {
                        $("#pais").append(
                            '<option value="' +
                                country[i].id +
                                '" selected>' +
                                country[i].name +
                                "</option>"
                        );
                    } else {
                        $("#pais").append(
                            '<option value="' +
                                country[i].id +
                                '">' +
                                country[i].name +
                                "</option>"
                        );
                    }
                }

                $("#type_id").append(
                    '<option value="' +
                        type_id.id +
                        '"selected>' +
                        type_id.name +
                        "</option>"
                );

                if (profile.img !== null) {
                    $("#imageUser-profile").attr(
                        "src",
                        profile.link + profile.img
                    );
                } else {
                    $("#imageUser-profile").attr(
                        "src",
                        "/adminlte/img/users/default.png"
                    );
                }
                $("#identificacion").val(profile.identification);
                $("#nombre").val(profile.name);
                $("#telefono").val(profile.phone);
                $("#correo").val(profile.email);
                $("#salesReg").text(saleReg);
                $("#salesRea").text(saleRea);
                $("#salesCan").text(saleCan);
                $("#salesPen").text(salePen);
                $("#salesTot").text(saleTot);
            }
        }
    });
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
