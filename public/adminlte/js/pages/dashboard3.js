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
            console.log(orders);
            let sales = 0; //recibe las ventas totales en tabla ventas
            let NewOrders = 0; //recibe los pedidos nuevas y las muestra en el toggle
            let ProcessOrder = 0; //recibe los pedidos en proceso y las muestra en el toggle
            let CancelOrder = 0; //recibe los pedidos cancelados y los muestra en el toggle
            let DeliveredOrder = 0; //recibe los pedidos pendientes de aprobacion de deposito y los muestra en el toggle
            var maxtotal = 0;
            var mintotal = 0;
            var subtotal = 0;
            var sumArray = 0;
            let dates = [];
            let total =[];
            var fechas = [];
            const options = {
                style: "currency",
                currency: "USD",
                maximumSignificantDigits: 3
            };
            const numberFormat = new Intl.NumberFormat("en-US", options);

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
            /*for para calcular ventas totales
            quantity_sales refleja la cantidad de las ventas*/
            for(var i = 0; i < orders.length; i++){
                var fecha = new Date(orders[i].delivery_date);
                let options = { month: 'long', day: 'numeric' };
                dates.push(fecha.toLocaleString('es', options));
            }
            /**
             * for para obtener la fecha de los envios
             * let option: es para dar el formato a la fecha
             */

            for(var i = 0; i < orders.length; i++){
                let date = new Date();
                let dia = ("0" + date.getDate()).slice(-2);
                let created = new Date(orders[i].created_at);
                let options = { day: 'numeric' };
                let created_day = created.toLocaleString('es', options);

                if(created_day == dia){
                    if(orders[i].state_order_id == 3){
                        subtotal = parseFloat(orders[i].total);
                        sumArray += subtotal;
                        total.push(sumArray)
                    }
                }
            }

            /**
             * for para recorrer los valores totales de las ventas
             */

            maxtotal = total.reduce((n,m) => Math.max(n,m), -Number.POSITIVE_INFINITY)
            mintotal = total.reduce((n,m) => Math.min(n,m), Number.POSITIVE_INFINITY)
            /*math.max: es para sacar el valor max de un array
            math.min: es para sacar el valor min de un array*/
            for(let i = 0; i < 7; i++){
                let date = new Date();
                date.setDate(date.getDate() - i);
                let finalDate = date.getDate()+'/'+ (date.getMonth()+1) +'/'+date.getFullYear();
                fechas.push(finalDate);
            }
            console.log(fechas);
            /**
             * for que calcula la fecha actual hasta 7 dias atras
             * Se usa en la frafica de ventas x dia
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










            var $visitorsChart = $('#visitors-chart')
            // eslint-disable-next-line no-unused-vars
            var visitorsChart = new Chart($visitorsChart, {
            data: {
            labels: fechas,
            datasets: [{
                type: 'line',
                data: total,
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
                data: [60, 80, 70, 67, 80, 77, 100],
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
                              if (value >= 1000) {
                                value /= 1000
                                value += 'k'
                              }

                              return '$' + value
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
