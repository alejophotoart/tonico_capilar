function editWarehouses(id, state_warehouse_id){
    $.ajax({
            url: "/bodegas/" + id,
            type: "GET",
            contentType: "application/json",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                contentType: "application/json"
            },
            success: function(r) {
                console.log(r);
                warehouse = r[0];
                country = r[1];
                state = r[2];
                city = r[3];
                state_warehouse = r[4];
            if(r){
                $("#editWarehouseModal").modal("show");
                $("#state_warehouse_id option").remove();
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
                $("#country_id_warehouse option").remove();
                for (var i = 0; i < country.length; i++) {
                    if(warehouse.city.state.country.id == country[i].id){
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
