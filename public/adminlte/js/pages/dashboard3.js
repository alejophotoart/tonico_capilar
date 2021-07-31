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
            var orders = r.orders //orders: recibe todas las ordenes
            var dates = r.dates;// dates: recibe de la base de datos la consulta donde solo me trae los registros de los ultimos 7 dias
            console.log(dates);
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

             for(let i = 0; i < 7; i++){
                let date = new Date();
                date.setDate(date.getDate() - i);
                let finalDate = date.getDate()+'/'+ (date.getMonth()+1) +'/'+date.getFullYear();
                fechas.push(finalDate);
            }
            /**
             * for que calcula la fecha actual hasta 7 dias atras
             * Se usa en la frafica de ventas x dia
            */

             for(let i = 0; i < 2; i++){
                let date = new Date();
                date.setDate(date.getDate() - i);
                let finalDate = date.getDate()+'/'+ (date.getMonth()+1) +'/'+date.getFullYear();
                datelocal.push(finalDate);
            }
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
            fechas.sort(); //Coloca la fechas de la menor a la mayor(osea la actual)
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
