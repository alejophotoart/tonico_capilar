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
            let sales = 0;
            var orders = r.orders
            console.log(orders);
            let dates = [];
            let total =[];
            var maxtotal = 0;
            var mintotal = 0;
            var subtotal = 0;
            const options = {
                style: "currency",
                currency: "USD",
                maximumSignificantDigits: 3
            };
            const numberFormat = new Intl.NumberFormat("en-US", options);

            for (var i = 0; i < orders.length; i++) {
                if (orders.length != 0) {
                    sales = i + 1;
                } else {
                    sales = 0;
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
            /*for para obtener la fecha de los envios
            let option: es para dar el formato a la fecha*/

            for(var i = 0; i < orders.length; i++){
                subtotal = parseFloat(orders[i].total);
                total.push(subtotal);
            }
            // for para recorrer los valores totales de las ventas

            maxtotal = total.reduce((n,m) => Math.max(n,m), -Number.POSITIVE_INFINITY)
            mintotal = total.reduce((n,m) => Math.min(n,m), Number.POSITIVE_INFINITY)
            /*math.max: es para sacar el valor max de un array
            math.min: es para sacar el valor min de un array*/


            var fechas = [];
            for(let i = 7; i > 0; i--){
                var date = new Date();
                date.setDate(date.getDate() - i);
                var finalDate = date.getDate()+'/'+ (date.getMonth()+1) +'/'+date.getFullYear();
                fechas.push(finalDate);
            }

            console.log(fechas);

            var $visitorsChart = $('#visitors-chart')
            // eslint-disable-next-line no-unused-vars
            var visitorsChart = new Chart($visitorsChart, {
            data: {
            labels: dates,
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
                        suggestedMax:""
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
