var i = 0;
function trashProduct(evt){
    console.log(evt);
    i = i - 1;
    $("." + evt).remove();
}
$(document).ready(function() {

    $("#addProduct").click(function(e) {
        e.preventDefault(); //eliminamos el evento por defecto
        if (i >= 9) {
            Swal.fire({
                icon: "warning",
                title: "Ops...",
                text: "Se permite maximo 10 grupos de items",
                confirmButtonColor: "#343a40"
            });
            return false;
        } else {
            i++;

            let elem = $("#ShowMoreProduct")
                .clone()
                .appendTo(".fieldGroupCopy")
                .attr("class", "input-group mb-3 copy-" + i)
                .attr("id", "copy");

            let element = document.querySelector(".copy-" + i);
            element.style.setProperty("display", "flex");
            elem.children()[2].children[0].value = "copy-" + i;
            elem.children()[1].className =
                "form-control col-md-11 custom-select copy";
            elem.children()[0].className = "form-control copy_quantity";

            return true;
        }
    });

});

function minTwoDigits(n) {
    return (n < 10 ? "0" : "") + n;
}

function EditOrder(id){
    let identification = document.getElementById("identification").value;
    let name = document.getElementById("name").value;
    let address = document.getElementById("address").value;
    let neighborhood = document.getElementById("neighborhood").value;
    let phone = document.getElementById("phone").value;
    let whatsapp = document.getElementById("whatsapp").value;
    let country_id = document.getElementById("country_id").value;
    let state_id = document.getElementById("state_id").value;
    let city_id = document.getElementById("city_id").value;
    let payment_type_id = document.getElementById("payment_type_id").value;
    let delivery_date = document.getElementById("delivery_date").value;
    let notes = document.getElementById("notes").value;
    let total2 = document.getElementById("total").value;
    // let delivery_price2 = document.getElementById("delivery_price").value;
    let img = document.getElementById("LoadVoucher").value;
    let quantity = [];
    let product = [];
    for (var i = 0; i < $(".copy_quantity").length; i++) {
        quantity.push($(".copy_quantity")[i].value);
    }
    for (var i = 0; i < $(".copy").length; i++) {
        product.push($(".copy")[i].value);
    }
    var prod_quan = [quantity, product];
    console.log(prod_quan);

    let total1 = total2.replace(/\$/g, "");
    let total = total1.replace(/\./g, "");
    // let delivery_price1 = delivery_price2.replace(/\$/g, "");
    // let delivery_price = delivery_price1.replace(/\./g, "");
}
