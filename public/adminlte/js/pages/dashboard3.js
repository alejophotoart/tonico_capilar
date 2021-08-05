/* global Chart:false */
$(function () {
  'use strict'

  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode = 'index'
  var intersect = true

  var $salesChart = $('#sales-chart')
  // eslint-disable-next-line no-unused-vars
  var salesChart = new Chart($salesChart, {
    type: 'bar',
    data: {
      labels: ['JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC'],
      datasets: [
        {
          backgroundColor: '#007bff',
          borderColor: '#007bff',
          data: [1000, 2000, 3000, 2500, 2700, 2500, 3000]
        },
        {
          backgroundColor: '#ced4da',
          borderColor: '#ced4da',
          data: [700, 1700, 2700, 2000, 1800, 1500, 2000]
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      tooltips: {
        mode: mode,
        intersect: intersect
      },
      hover: {
        mode: mode,
        intersect: intersect
      },
      legend: {
        display: false
      },
      scales: {
        yAxes: [{
          // display: false,
          gridLines: {
            display: true,
            lineWidth: '4px',
            color: 'rgba(0, 0, 0, .2)',
            zeroLineColor: 'transparent'
          },
          ticks: $.extend({
            beginAtZero: true,

            // Include a dollar sign in the ticks
            callback: function (value) {
              if (value >= 1000) {
                value /= 1000
                value += 'k'
              }

              return '$' + value
            }
          }, ticksStyle)
        }],
        xAxes: [{
          display: true,
          gridLines: {
            display: false
          },
          ticks: ticksStyle
        }]
      }
    }
  })

    $.ajax({
        url: "/resumen/sales",
        type: "GET",
        contentType: "application/json",
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            contentType: "application/json"
        },
        success: function(r) {
            console.log(r);

            var orders = r.orders //orders: recibe todas las ordenes
            var dates = r.dates;// dates: recibe de la base de datos la consulta donde solo me trae los registros de los ultimos 7 dias
            var products = r.products; //products: recibe el array de todos los prodcutos
            let sales = 0; //recibe las ventas totales en tabla ventas
            let NewOrders = 0; //recibe los pedidos nuevas y las muestra en el toggle
            let ProcessOrder = 0; //recibe los pedidos en proceso y las muestra en el toggle
            let CancelOrder = 0; //recibe los pedidos cancelados y los muestra en el toggle
            let DeliveredOrder = 0; //recibe los pedidos pendientes de aprobacion de deposito y los muestra en el toggle
            var maxtotal = 0;// recibe el maximo valor de los valores del total
            var subtotal = 0; //recibe los valores en el for
            var sumArray = 0; //suma los valores
            let total = 0; // acumula los totales segun la fecha
            let count = 0;
            var percent = 0; // acumula los totales de la fecha actual y la anterior
            var fechas = []; // recibe las fechas de la actual a 7 dias antes
            var datelocal = []; // recibe la fecha actual y la del dia anterior
            var returnTotal = {}; // acumula las fechas y sus totales definitivos
            var returnCount = {}; // acumula las ventas segun la fecha actual a 7 dias atras
            var returnPercentage = {}; // acumula los totales segun la fecha actual y la anterior
            var arrCountProd = {}; //acumula cuantas veces se repite ese producto en las ventas
            var arrPackage = {}; //acumulas cuantos productos hay en un pedido

            for (var i = 0; i < orders.length; i++) {
                if(orders[i].state_order_id == 3){
                    if (orders.length != 0) {
                        sales++;
                    } else {
                        sales = 0;
                    }
                }

            }
            $("#quantity_sales").text(sales);
            /**
             * muestra en la tabla de ventas los pedidos entregados
             */
             function last7Days(){
                let arr = [];
                var today = new Date();
                let i = 0;
                do {
                  if(i != 0)
                  today.setDate(today.getDate() - 1);
                  let finalDate = today.getDate()+'/'+ (today.getMonth()+1) +'/'+today.getFullYear();
                  arr.push(finalDate);
                  i++;
                }  while(i < 7)

                return arr;
              }
              fechas = last7Days();
              /**
             * for que calcula la fecha actual hasta 7 dias atras
             * Se usa en la frafica de ventas x dia
            */

               function last2Days(){
                let arrlast2Day = [];
                var today = new Date();
                let i = 0;
                do {
                  if(i != 0)
                  today.setDate(today.getDate() - 1);
                  let finalDate = today.getDate()+'/'+ (today.getMonth()+1) +'/'+today.getFullYear();
                  arrlast2Day.push(finalDate);
                  i++;
                }  while(i < 2)

                return arrlast2Day;
              }
              datelocal = last2Days();
            /**
             * for que saca la fecha actual y la del dia anterior
             * esto es para hacer el crecimiento de ventas
             */

            for(let f = 0; f < fechas.length; f++){
                for(let d = 0; d < dates.length; d++){
                    let date = new Date(dates[d].fecha);
                    date.setDate(date.getDate());
                    var endDate = date.getDate()+'/'+ (date.getMonth()+1) +'/'+date.getFullYear();
                    if(fechas[f] == endDate){
                        if(dates[d].state_order_id == 3){
                            let subtotal = parseFloat(dates[d].total);
                            total = total + subtotal;
                            returnTotal[endDate] = total;
                            count = count + 1;
                            returnCount[endDate] = count
                        }
                    }
                }
                count = 0;
                total = 0;
            }
            var keys = Object.values(returnTotal);
            var counts = Object.values(returnCount);

            /**
             * for para recorrer los valores totales de las ventas
             */

            maxtotal = keys.reduce((n,m) => Math.max(n,m), -Number.POSITIVE_INFINITY)
            /**
             * math.max: es para sacar el valor max de un array
             * math.min: es para sacar el valor min de un arrays
             */

            for(var i = 0; i < orders.length; i++){
                if(orders[i].state_order_id == 1 || orders[i].state_order_id == 7){
                    NewOrders++;
                }else{
                    if(orders[i].state_order_id == 2){
                        ProcessOrder++;
                    }else{
                        if(orders[i].state_order_id == 3){
                            DeliveredOrder++;
                        }else{
                            if(orders[i].state_order_id == 4){
                                CancelOrder++;
                            }
                        }
                    }
                }
            }
            $("#toggleNewOrder").text(NewOrders);
            $("#toggleProcessOrder").text(ProcessOrder);
            $("#toggleCancelOrder").text(CancelOrder);
            $("#toggleDeliveredOrder").text(DeliveredOrder);
            /**
             * For que cuenta las ventas segun el estado del pedido
             * los almacena en las variable y los muestra segun los id de la etiqueta
             */
            fechas.reverse(); //Reversa el array de fechas y la orden ade menor a mayor
            keys.reverse(); //reversa el array y lo ordenar de abajo hacia arriba segun el key
            counts.reverse(); //reversa el array de contar ventas por dia

                for(let g = 0; g < datelocal.length; g++){
                    for(let h = 0; h < dates.length; h++){
                        let datePercent = new Date(dates[h].fecha);
                        datePercent.setDate(datePercent.getDate());
                        let dateAge = datePercent.getDate()+'/'+ (datePercent.getMonth()+1) +'/'+datePercent.getFullYear();
                        if(datelocal[g] == dateAge){
                            if(dates[h].state_order_id == 3){
                                let tot = parseFloat(dates[h].total);
                                percent = percent + tot;
                                returnPercentage[datelocal[g]] = percent;
                        }
                    }
                }
                percent = 0;
            }
            var percentage = Object.values(returnPercentage);
            for(var b = 0; b < percentage.length; b++){
                var dayActully = percentage[0];
                var dayPast = percentage[1];
            }
            if(dayActully == "" || dayActully == null || dayActully == undefined){
                dayActully = 0;
                count = ((dayActully/dayPast)-1)*100;
               var percentageEnd = count.toFixed() + "%";
            }else{
                count = ((dayActully/dayPast)-1)*100;
                var percentageEnd = count.toFixed() + "%";
            }

            if(count <= 0){
                $(".percentage").text(percentageEnd);
                let elem = document.querySelector(".percentage");
                elem.style.setProperty("color", "red");
                $(".percentage").each(function(){
                    $(this).append('<i class="fas fa-arrow-down"></i>');
                });
            }else{
                if(count > 0){
                    $(".percentage").text(percentageEnd);
                    let elem = document.querySelector(".percentage");
                    elem.style.setProperty("color", "green");
                    $(".percentage").each(function(){
                        $(this).append('<i class="fas fa-arrow-up"></i>');
                    });
                }else{
                    if(isNaN(count)){
                        $(".percentage").text("No se registran ventas hoy");
                        let elem = document.querySelector(".percentage");
                        elem.style.setProperty("opacity", "0.5");
                        elem.style.setProperty("font-size", "0.85em")
                    }
                }
            }
            /**
             * for para recorrer la fecha actual y la anterior para sacar el porcentaje de crecimiento
             */
            let totalP = 0;
            var countSum=0;
            function conuntProd(){
                for (let p = 0; p < products.length; p++) {
                    for (let o = 0; o < orders.length; o++) {
                        if(orders[o].state_order_id == 3){
                            for (let d = 0; d < orders[o].order_items.length; d++) {
                                if(products[p].id == orders[o].order_items[d].product_id){
                                    totalP ++;
                                    arrCountProd[[products[p].id]] =totalP;
                                }
                            }
                        }
                    }
                    totalP = 0;
                }
                var keysdown = Object.values(arrCountProd);
                keysdown.forEach (function(numero){
                    countSum += numero;
                });
            }
            conuntProd();
            var i = -1;
            var rturn = {};
            var keysup = Object.values(arrCountProd);


            for (let f = 0; f < keysup.length; f++) {
                i++
                var tr = document.getElementById("insertTD-" + i);
                var c = (keysup[f]/countSum)*100;
                var string_c = c.toFixed(2) +"%"
                var td = document.createElement("td");
                if(string_c >= "20"){
                    $(td).each(function(){
                        $(this).append('<i class="text-success fas fa-arrow-up"></i>');
                        $(this).append('<small style="font-size: .85em;" class="text-success mr-1" id="percentSales">'+ string_c +'</small>');
                        $(this).append('Sold');
                    });
                    tr.appendChild(td);
                }else{
                    if(string_c <= "19"){
                        $(td).each(function(){
                            $(this).append('<i class="text-danger fas fa-arrow-down"></i>');
                            $(this).append('<small style="font-size: .85em;" class="text-danger mr-1" id="percentSales">'+ string_c +'</small>');
                            $(this).append('Sold');
                        });
                        tr.appendChild(td);
                    }
                }
            }
            /**
             * proceso para sacar el porcentaje de cada producto para saber cual es el pedido que mas veces se vende
             */
             let totalPK = 0;
             var PKSum = 0;
             function packageCount(){
                    for (let o = 0; o < orders.length; o++) {
                        if(orders[o].state_order_id == 3){
                            for (let d = 0; d < orders[o].order_items.length; d++) {
                                if(orders[o].id == orders[o].order_items[d].order_id){
                                    totalPK ++;
                                    arrPackage['Pedido #'+[orders[o].id]] = totalPK;
                                }
                            }
                        }
                        totalPK = 0;
                    }
                for (let z = 0; z < orders.length; z++) {
                    if(orders[z].state_order_id == 3){
                        for (let d = 0; d < orders[z].order_items.length; d++) {
                            PKSum++; // almacena el total de order_items
                        }
                    }
                }
            }
            packageCount();

            var PKS = Object.values(arrPackage);
            var PKone = 0;
            for (let x = 0; x < PKS.length; x++) {
                if(PKS[x] == 1){
                    PKone++;// almacena cuantas ventas han sido de un producto
                }
            }
            var PKpercent = (PKone/PKSum)*100;
            var string_pkone = PKpercent.toFixed(2) +"%"
            var contentOne = document.getElementById("percentOne");
            var span = document.createElement("span");
            var span_title = document.createElement("span");
            $(span).each(function(){
                $(this).attr("class","font-weight-bold");
                $(this).append('<i class="ion ion-android-arrow-up text-danger"> </i> ');
                $(this).append(string_pkone);
            });
            $(span_title).each(function(){
                $(this).attr("class", "text-muted");
                $(this).append("1 PRODUCTO");
            });
            contentOne.appendChild(span);
            contentOne.appendChild(span_title);
            /**
             * proceso para el primer indicador de porcentaje de ventas de un producto
             */

             var PKStwo = Object.values(arrPackage);
             var PKtwo = 0;
             for (let x = 0; x < PKStwo.length; x++) {
                 if(PKS[x] >= 2 && PKS[x] <= 3 ){
                    PKtwo++;// almacena cuantas ventas han sido de un producto
                 }
             }
             var PKpercenttwo = (PKtwo/PKSum)*100;
             var string_pktwo = PKpercenttwo.toFixed(2) +"%"
             var contentTwo = document.getElementById("percentTwo");
             var spanTwo = document.createElement("span");
             var span_title_Two = document.createElement("span");
             $(spanTwo).each(function(){
                 $(this).attr("class","font-weight-bold");
                 $(this).append('<i class="ion ion-android-arrow-up text-warning"> </i> ');
                 $(this).append(string_pktwo);
             });
             $(span_title_Two).each(function(){
                 $(this).attr("class", "text-muted");
                 $(this).append("2 a 3 PRODUCTOS");
             });
             contentTwo.appendChild(spanTwo);
             contentTwo.appendChild(span_title_Two);
            /**
             * proceso para el segundo indicador de porcentaje de ventas de un producto
             */

             var PKSthree = Object.values(arrPackage);
             var PKthree = 0;
             for (let x = 0; x < PKSthree.length; x++) {
                 if(PKS[x] >= 4 ){
                    PKthree++;// almacena cuantas ventas han sido de un producto
                 }
             }
             var PKpercentthree = (PKthree/PKSum)*100;
             var string_pkthree = PKpercentthree.toFixed(2) +"%"
             var contentthree = document.getElementById("percentThree");
             var spanthree = document.createElement("span");
             var span_title_three = document.createElement("span");
             $(spanthree).each(function(){
                 $(this).attr("class","font-weight-bold");
                 $(this).append('<i class="ion ion-android-arrow-up text-success"> </i> ');
                 $(this).append(string_pkthree);
             });
             $(span_title_three).each(function(){
                 $(this).attr("class", "text-muted");
                 $(this).append("+4 PRODUCTOS");
             });
             contentthree.appendChild(spanthree);
             contentthree.appendChild(span_title_three);


            var $visitorsChart = $('#visitors-chart')
            // eslint-disable-next-line no-unused-vars
            var visitorsChart = new Chart($visitorsChart, {
            data: {
            labels: fechas,
            datasets: [{
                type: 'line',
                data: keys,
                backgroundColor: 'transparent',
                borderColor: '#007bff',
                pointBorderColor: '#007bff',
                pointBackgroundColor: '#007bff',
                fill: false
                // pointHoverBackgroundColor: '#007bff',
                // pointHoverBorderColor    : '#007bff'
            },
            {
                type: 'line',
                data: counts,
                backgroundColor: 'tansparent',
                borderColor: '#ced4da',
                pointBorderColor: '#ced4da',
                pointBackgroundColor: '#ced4da',
                fill: false
                // pointHoverBackgroundColor: '#ced4da',
                // pointHoverBorderColor    : '#ced4da'
            }]
            },
            options: {
            maintainAspectRatio: false,
            tooltips: {
                mode: mode,
                intersect: intersect
            },
            hover: {
                mode: mode,
                intersect: intersect
            },
            legend: {
                display: false
            },
                scales: {
                    yAxes: [{
                    // display: false,
                    gridLines: {
                        display: true,
                        lineWidth: '4px',
                        color: 'rgba(0, 0, 0, .2)',
                        zeroLineColor: 'transparent'
                    },
                    ticks: $.extend({
                        beginAtZero: true,
                            // Include a dollar sign in the ticks
                            callback: function (value) {
                                if(parseInt(value) >= 1000){
                                    return '$' + value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                                  } else {
                                    return '$' + value;
                                  }

                            },

                        suggestedMax:maxtotal
                    }, ticksStyle)
                    }],
                    xAxes: [{
                    display: true,
                    gridLines: {
                        display: false
                    },
                    ticks: ticksStyle
                    }]
                }
                }
            })
        }
    });
})

// lgtm [js/unused-local-variable]
