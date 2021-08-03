function editWarehouses(id, state_warehouse_id, country_id, city_id, state_id){
    $.ajax({
            url: "/bodegas/" + id,
            type: "GET",
            contentType: "application/json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                contentType: "application/json"
            },
            success: function(r) {
                changeCountryType(state_id, country_id);
                changeStateType(state_id, city_id);

                warehouse = r[0];
                country = r[1];
                state = r[2];
                city = r[3];
                state_warehouse = r[4];

            if(r){
                $("#editWarehouseModal").modal("show");
                $("#name_warehouse").val(warehouse.name);
                $("#state_warehouse_id option").remove();
                $("#country_id_warehouse option").remove();
                $("#buttonUpdate").data("id", warehouse.id);

                for(var i = 0; i < state_warehouse.length; i++){
                    if(state_warehouse_id == state_warehouse[i].id){
                        $("#state_warehouse_id").append(
                            '<option value="' +
                                state_warehouse[i].id +
                                '" selected>' +
                                state_warehouse[i].name +
                                "</option>"
                        );
                    }else{
                        $("#state_warehouse_id").append(
                            '<option value="' +
                            state_warehouse[i].id +
                            '">' +
                            state_warehouse[i].name +
                            "</option>"
                        );
                    }
                }
                for (var i = 0; i < country.length; i++) {
                    if(country_id == country[i].id){
                        $("#country_id_warehouse").append(
                            '<option value="' +
                                country[i].id +
                                '" selected>' +
                                country[i].name +
                                "</option>"
                        );
                    }else{
                        $("#country_id_warehouse").append(
                            '<option value="' +
                                country[i].id +
                                '">' +
                                country[i].name +
                                "</option>"
                        );
                    }
                }
            }
        }
    });
}

var country_code_value ='{{ old("country_id_warehouse") }}';
if (country_code_value && country_code_value != "") {
    changeCountryType(country_code_value);
}
var state_code_value =
    '{{ old("state_id_warehouse") }}';
if (state_code_value && state_code_value != "") {
    changeStateType(state_code_value);
}

function changeCountryType(state_code, country_code) {

    var state_id = state_code;
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
                $("#state_id_warehouse").prop("disabled", false);
                $("#state_id_warehouse option").remove();
                for (var i = 0; i < r.d.states.length; i++) {
                    if (state_id == r.d.states[i].id) {
                        $("#state_id_warehouse").append(
                            '<option value="' +
                                r.d.states[i].id +
                                '" selected>' +
                                r.d.states[i].name +
                                "</option>"
                        );
                    } else {
                        $("#state_id_warehouse").append(
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

function changeStateType(state_code, city_code) {
    var city_id = city_code;

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
                $("#city_id_warehouse").prop("disabled", false);
                $("#city_id_warehouse option").remove();
                for (var i = 0; i < r.d.cities.length; i++) {
                    if (city_id == r.d.cities[i].id) {
                        $("#city_id_warehouse").append(
                            '<option value="' +
                                r.d.cities[i].id +
                                '" selected>' +
                                r.d.cities[i].name +
                                "</option>"
                        );
                    } else {
                        $("#city_id_warehouse").append(
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

function editInfowarehouse(){
     var id_w = $("#buttonUpdate").data("id");

     let name = document.getElementById("name_warehouse").value;
     let city_id = document.getElementById("city_id_warehouse").value;
     let state_warehouse_id = document.getElementById("state_warehouse_id").value;

     if (
        country_id == 0 ||
        country_id == "" ||
        state_id == 0 ||
        state_id == "" ||
        city_id == 0 ||
        city_id == "" ||
        state_warehouse_id == 0 ||
        state_warehouse_id == ""
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
            text: "Deseas editar la bodega " + name,
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
                    city_id,
                    state_warehouse_id
                };
                let timerInterval;
                Swal.fire({
                    title: "Actualizando Bodega",
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
                    url: "/bodegas/" + id_w + "/update",
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
                                        url + "/bodegas"
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
                });
            }
        });
    }

}
