function filterForDate() {

    var date = document.getElementById("datepicker").value;
     
    if( date.length > 10 ){

        var startDate = date.slice(0,10);
        var endDate = date.slice(13, 23);

        var url = "/resumen/" + startDate + "/" + endDate + "/filterDate"

    } else {

        var url = "/resumen/" + date + "/filterDate"

    }


    // var myTable = $('#tableResume').DataTable();
    // myTable.row( 'tbody tr' ).remove().draw();

    var table = $('#tableResume').DataTable();
    table.clear().draw();

    // $("#tableResume tbody tr").remove();
    // $("#totalText").remove();
    // $("#total").remove();
    // $("#totalDelivery").remove();
    // $("#totalNeto").remove();
    document.getElementById("tableResume").deleteTFoot();

    $.ajax({
        
        url: url,
        type: "GET",
        contentType: "application/json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            contentType: "application/json"
        },
        success: function(r) {

            console.log(r);
            countryXOrdes = r.countryXOrdes;
            delivery = r.delivery;
            totalCosto = r.totalCosto;
            totalNeto = r.totalNeto;
            subtotal = r.subtotal;

            const options = {style: "currency", currency: "USD", maximumSignificantDigits: 3};
            const numberFormat = new Intl.NumberFormat("en-US", options);

            if (countryXOrdes.length === 0) {
                var dataTable = $('#tableResume').DataTable();
                    dataTable.row.add([
                    "No se registran ventas este dia",
                    "$0",
                    "0",
                    "$0",
                    "0",
                    "$0",
                    "$0"
                ]).draw();
                var table = document.getElementById("tableResume");
                var footer = table.createTFoot();
                $(footer).css("font-weight", "bold")
                var row = footer.insertRow(0);
                var cell = row.insertCell(0);
                cell.innerHTML = "Total";

                var cell1 = row.insertCell(1);
                cell1.innerHTML = "$0";
                $(cell1).attr('colspan', 2);

                var cell2 = row.insertCell(2);
                cell2.innerHTML = "$0";

                var cell3 = row.insertCell(3);
                cell3.innerHTML = "$0";
                $(cell3).attr('colspan', 2);

                var cell4 = row.insertCell(4);
                cell4.innerHTML = "$0";
            }else{
                for (let i = 0; i < countryXOrdes.length; i++) {
                    var dataTable = $('#tableResume').DataTable();
                        dataTable.row.add([
                        countryXOrdes[i].pais,
                        numberFormat.format(countryXOrdes[i].subtotal),
                        countryXOrdes[i].sales,
                        numberFormat.format(countryXOrdes[i].delivery),
                        countryXOrdes[i].salesProd,
                        numberFormat.format(countryXOrdes[i].prodCosto),
                        numberFormat.format(countryXOrdes[i].neto)
                    ]).draw();
                }
                var table = document.getElementById("tableResume");
                var footer = table.createTFoot();
                $(footer).css("font-weight", "bold")
                var row = footer.insertRow(0);
                var cell = row.insertCell(0);
                cell.innerHTML = "Total";

                var cell1 = row.insertCell(1);
                cell1.innerHTML = numberFormat.format(subtotal);
                $(cell1).attr('colspan', 2);

                var cell2 = row.insertCell(2);
                cell2.innerHTML = numberFormat.format(delivery);

                var cell3 = row.insertCell(3);
                cell3.innerHTML = numberFormat.format(totalCosto);
                $(cell3).attr('colspan', 2);

                var cell4 = row.insertCell(4);
                cell4.innerHTML = numberFormat.format(totalNeto);
            }
        }
    });
}
