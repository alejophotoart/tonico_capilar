function ShowOrderModal(id) {
    document.getElementById("identification_client").readOnly = true;
    document.getElementById("name_client").readOnly = true;
    document.getElementById("address_client").readOnly = true;
    document.getElementById("neighborhood_client").readOnly = true;
    document.getElementById("phone_client").readOnly = true;
    document.getElementById("whatsapp_client").readOnly = true;
    document.getElementById("country_client").readOnly = true;
    document.getElementById("state_client").readOnly = true;
    document.getElementById("city_client").readOnly = true;
    document.getElementById("payment_type_id_client").readOnly = true;
    document.getElementById("delivery_date_client").readOnly = true;
    document.getElementById("notes_client").readOnly = true;

    $.ajax({
        url: "/pedidos/mostrar/" + id,
        type: "GET",
        contentType: "application/json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            contentType: "application/json"
        },
        success: function(r) {
            console.log(r);

            order = r[0];
            client = r[0].client;
            address = r[1];
            payment_type = r[0].payment_type;
            state_order = r[0].state_order;
            user = r[0].user;
            product = r[2];
            country = r[0].city.state.country;
            state = r[0].city.state;
            city = r[0].city;

            const options = {
                style: "currency",
                currency: "USD",
                maximumSignificantDigits: 3
            };
            const numberFormat = new Intl.NumberFormat("en-US", options);

            if (r) {
                $("#ModalShowInfo").modal("show");
                $("#identification_client").val(client.identification);
                $("#name_client").val(client.name);
                $("#phone_client").val(client.phone);
                $("#whatsapp_client").val(client.whatsapp);
                $("#country_client").val(country.name);
                $("#state_client").val(state.name);
                $("#city_client").val(city.name);
                $("#payment_type_id_client").val(payment_type.name);
                $("#delivery_date_client").val(order.delivery_date);
                $("#notes_client").val(order.notes);
                $("#total_price").val(numberFormat.format(order.total));
                $("#delivery_price_client").val(
                    numberFormat.format(order.delivery_price)
                );
                $("#salesman").text(user.name);
                $("#ordersNum").text(order.id);

                if (payment_type.id == 2) {
                    $("#buttonVoucher").prop("hidden", false);
                } else {
                    if (payment_type.id == 1) {
                        $("#buttonVoucher").prop("hidden", true);
                    }
                }

                for (var i = 0; i < address.length; i++) {
                    if (order.address_id == address[i].id) {
                        $("#address_client").val(address[i].address);
                        $("#neighborhood_client").val(address[i].neighborhood);
                    }
                }
                $(".copy_content").remove();
                for (var i = 0; i < order.order_items.length; i++) {
                    for (var p = 0; p < product.length; p++) {
                        if (order.order_items[i].product_id == product[p].id) {
                            let content = $("#contentProductShow")
                                .clone()
                                .attr("class", "input-group mb-3 copy_content")
                                .prop("hidden", false)
                                .appendTo(".fieldGroup");
                            content.children()[0].value =
                                order.order_items[i].quantity;
                            content.children()[1].value = product[p].name;
                        }
                    }
                }
            }
        }
    });
}

function showVoucherCheck(id) {
    $.ajax({
        url: "/pedidos/mostrar/" + id,
        type: "GET",
        contentType: "application/json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            contentType: "application/json"
        },
        success: function(r) {
            console.log(r);
            order = r[0];

            if (r) {
                Swal.fire({
                    imageUrl: "/" + order.link + order.img,
                    imageHeight: 700,
                    imageWidth: 500,
                    imageAlt: "A tall image",
                    confirmButtonColor: "#343a40"
                });
            }
        }
    });
}
