var state_code_value = '{{ old("state_id") }}';
if (state_code_value && state_code_value != "") {
    changeStateType(state_code_value);
}

var country_code_value = '{{ old("country_id") }}';
if (country_code_value && country_code_value != "") {
    changeCountryType(country_code_value);
}
function changeCountryType(country_code) {
    // llama estados o departamentos
    var state_id = localStorage.getItem("state_id");

    $.ajax({
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: "/optionCountry/state/" + country_code,
        data: null,
        success: function(r) {
            if (!r) {
                r = JSON.parse(r);
            }
            if (r) {
                $("#state_id").prop("disabled", false);
                $("#state_id option").remove();
                $("#city_id option").remove();
                $("#city_id").append(
                    '<option value="0" selected disabled>Seleccione ciudad</option>'
                );
                for (var i = 0; i < r.d.states.length; i++) {
                    if (
                        state_id &&
                        state_id != "" &&
                        r.d.states[i].id == state_id
                    ) {
                        $("#state_id").append(
                            '<option value="' +
                                r.d.states[i].id +
                                '">' +
                                r.d.states[i].name +
                                "</option>"
                        );
                    } else {
                        $("#state_id").append(
                            '<option value="' +
                                r.d.states[i].id +
                                '">' +
                                r.d.states[i].name +
                                "</option>"
                        );
                    }
                }
            }
        },
        error: function(textStatus, errorThrown) {
            alert("error");
        }
    });
}

function changeStateType(state_code) {
    // llama ciudades relacionadas a los departamentos
    var city_id = localStorage.getItem("city_id");

    $.ajax({
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        },
        url: "/optionState/city/" + state_code,
        data: null,
        success: function(r) {
            if (!r) {
                r = JSON.parse(r);
            }
            if (r) {
                $("#city_id").prop("disabled", false);
                $("#city_id").append(
                    '<option value="0" selected disabled>Municipio</option>'
                );
                $("#city_id option").remove();
                for (var i = 0; i < r.d.cities.length; i++) {
                    if (
                        city_id &&
                        city_id != "" &&
                        r.d.cities[i].id == city_id
                    ) {
                        $("#city_id").append(
                            '<option value="' +
                                r.d.cities[i].id +
                                '">' +
                                r.d.cities[i].name +
                                "</option>"
                        );
                    } else {
                        $("#city_id").append(
                            '<option value="' +
                                r.d.cities[i].id +
                                '">' +
                                r.d.cities[i].name +
                                "</option>"
                        );
                    }
                }
            }
        },
        error: function(textStatus, errorThrown) {
            alert("error");
        }
    });
}
function changeCity(city_id) {
    localStorage.setItem("city_id", city_id);
}

function ShowCreateOrderModal(id) {
    $.ajax({
        url: "/pedidos/" + id,
        type: "GET",
        contentType: "application/json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            contentType: "application/json"
        },
        success: function(r) {
            console.log(r);
            user = r[0];
            role_id = r[0].role;
            country = r[1];
            products = r[2];
            payment_type = r[3];

            if (r) {
                $("#country_id option").remove();
                $("#state_id option").remove();
                $("#city_id option").remove();
                $("#payment_type_id option").remove();
                $("#product option").remove();
                $(".product_copy option").remove();
                $("#country_id").append(
                    '<option value="0" selected disabled>Seleccione Pais</option>'
                );
                $("#state_id").append(
                    '<option value="0" selected disabled>Seleccione departamento</option>'
                );
                $("#city_id").append(
                    '<option value="0" selected disabled>Seleccione ciudad</option>'
                );
                $("#payment_type_id").append(
                    '<option value="0" selected disabled>Seleccione tipo de pago</option>'
                );
                for (var i = 0; i < country.length; i++) {
                    $("#country_id").append(
                        '<option value="' +
                            country[i].id +
                            '">' +
                            country[i].name +
                            "</option>"
                    );
                }
                for (var i = 0; i < payment_type.length; i++) {
                    $("#payment_type_id").append(
                        '<option value="' +
                            payment_type[i].id +
                            '">' +
                            payment_type[i].name +
                            "</option>"
                    );
                }
                for (var i = 0; i < products.length; i++) {
                    $("#product").append(
                        '<option value="' +
                            products[i].id +
                            '">' +
                            products[i].name +
                            "</option>"
                    );
                }

                for (var i = 0; i < products.length; i++) {
                    $(".product_copy").append(
                        '<option value="' +
                            products[i].id +
                            '">' +
                            products[i].name +
                            "</option>"
                    );
                }
                $("#CreateOrderModal").modal("show");
                $("#name_user").val(user.name);
                $("#role_id_user").val(role_id.name);
            }
        }
    });
}
