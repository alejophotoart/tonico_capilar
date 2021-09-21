$(function () {
    "use strict";
    $("#tablesResume").DataTable();
    var e = { fontColor: "#495057", fontStyle: "bold" },
        t = $("#sales-chart");
    new Chart(t, {
        type: "bar",
        data: {
            labels: ["JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"],
            datasets: [
                { backgroundColor: "#007bff", borderColor: "#007bff", data: [1e3, 2e3, 3e3, 2500, 2700, 2500, 3e3] },
                { backgroundColor: "#ced4da", borderColor: "#ced4da", data: [700, 1700, 2700, 2e3, 1800, 1500, 2e3] },
            ],
        },
        options: {
            maintainAspectRatio: !1,
            tooltips: { mode: "index", intersect: !0 },
            hover: { mode: "index", intersect: !0 },
            legend: { display: !1 },
            scales: {
                yAxes: [
                    {
                        gridLines: { display: !0, lineWidth: "4px", color: "rgba(0, 0, 0, .2)", zeroLineColor: "transparent" },
                        ticks: $.extend(
                            {
                                beginAtZero: !0,
                                callback: function (e) {
                                    return e >= 1e3 && ((e /= 1e3), (e += "k")), "$" + e;
                                },
                            },
                            e
                        ),
                    },
                ],
                xAxes: [{ display: !0, gridLines: { display: !1 }, ticks: e }],
            },
        },
    }),
        $.ajax({
            url: "/resumen/sales",
            type: "GET",
            contentType: "application/json",
            headers: { "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"), contentType: "application/json" },
            success: function (t) {
                var a,
                    r = t.orders,
                    n = t.dates,
                    s = t.products,
                    o = 0,
                    i = t.rolUser,
                    d = t.idUser,
                    l = 0,
                    c = 0,
                    p = 0,
                    h = 0,
                    f = 0,
                    g = 0,
                    u = 0,
                    x = 0,
                    m = 0,
                    _ = 0,
                    v = 0,
                    b = 0,
                    C = 0;
                let D = 0,
                    O = 0;
                for (var y, w = 0, S = [], P = [], N = {}, E = {}, F = {}, T = {}, k = {}, j = 0; j < r.length; j++) 3 == r[j].state_order_id && (0 != r.length ? o++ : (o = 0));
                $("#quantity_sales").text(o),
                    (P = (function () {
                        for (var e in n) {
                            let a = new Date(n[e].fecha);
                            a.setDate(a.getDate());
                            var t = a.getDate() + "/" + (a.getMonth() + 1) + "/" + a.getFullYear();
                            S.push(t);
                        }
                        var a = new Date();
                        let r = a.getDate() + "/" + (a.getMonth() + 1) + "/" + a.getFullYear();
                        if (1 == S.includes(r)) {
                            let e = [];
                            var s = new Date();
                            let t = 0;
                            do {
                                0 != t && s.setDate(s.getDate() - 1);
                                let a = s.getDate() + "/" + (s.getMonth() + 1) + "/" + s.getFullYear();
                                e.push(a), t++;
                            } while (t < 7);
                            return e;
                        }
                        {
                            let e = [];
                            (s = new Date()).setDate(s.getDate() - 1);
                            let t = 0;
                            do {
                                0 != t && s.setDate(s.getDate() - 1);
                                let a = s.getDate() + "/" + (s.getMonth() + 1) + "/" + s.getFullYear();
                                e.push(a), t++;
                            } while (t < 7);
                            return e;
                        }
                    })()),
                    (y = (function () {
                        let e = [];
                        var t = new Date();
                        let a = 0;
                        do {
                            0 != a && t.setDate(t.getDate() - 1);
                            let r = t.getDate() + "/" + (t.getMonth() + 1) + "/" + t.getFullYear();
                            e.push(r), a++;
                        } while (a < 2);
                        return e;
                    })());
                for (let e = 0; e < P.length; e++) {
                    for (let t = 0; t < n.length; t++) {
                        let a = new Date(n[t].fecha);
                        a.setDate(a.getDate());
                        var A = a.getDate() + "/" + (a.getMonth() + 1) + "/" + a.getFullYear();
                        P[e] == A && ((D += parseFloat(n[t].total)), (N[A] = D), (O += 1), (E[A] = O));
                    }
                    (O = 0), (D = 0);
                }
                console.log();
                var U = Object.keys(N);
                for (var I in P) 0 == U.includes(P[I]) && (N[P[I]] = 0);
                var R = Object.keys(E);
                for (var B in P) 0 == R.includes(P[B]) && (E[P[B]] = 0);
                var M = Object.values(N),
                    L = Object.values(E);
                for (a = M.reduce((e, t) => Math.max(e, t), -Number.POSITIVE_INFINITY), j = 0; j < r.length; j++)
                    1 == r[j].state_order_id
                        ? l++
                        : 2 == r[j].state_order_id
                        ? c++
                        : 3 == r[j].state_order_id
                        ? h++
                        : 4 == r[j].state_order_id
                        ? p++
                        : 5 == r[j].state_order_id
                        ? f++
                        : 6 == r[j].state_order_id
                        ? g++
                        : 7 == r[j].state_order_id && u++;
                if (4 == i)
                    for (var Y = 0; Y < r.length; Y++)
                        d == r[Y].user_id &&
                            (1 == r[Y].state_order_id
                                ? x++
                                : 2 == r[Y].state_order_id
                                ? m++
                                : 3 == r[Y].state_order_id
                                ? v++
                                : 4 == r[Y].state_order_id
                                ? _++
                                : 5 == r[Y].state_order_id
                                ? b++
                                : (6 != r[Y].state_order_id && 7 != r[Y].state_order_id) || C++);
                $("#toggleNewOrder").text(l),
                    $("#toggleProcessOrder").text(c),
                    $("#toggleCancelOrder").text(p),
                    $("#toggleDeliveredOrder").text(h),
                    0 !== l && $("#NewOrders").text(l),
                    0 !== c && $("#ProcessOrders").text(c),
                    0 !== p && $("#CancelOrders").text(p),
                    0 !== h && $("#DeliveredOrders").text(h),
                    0 !== f && $("#PendingOrders").text(f),
                    0 !== g && $("#PendingAprobationLogistic").text(g),
                    0 !== u && $("#PendingAprobationDeposit").text(u),
                    0 !== x && $("#NewOrdersSales").text(x),
                    0 !== m && $("#ProcessOrdersSales").text(m),
                    0 !== _ && $("#CancelOrdersSales").text(_),
                    0 !== v && $("#DeliveredOrdersSales").text(v),
                    0 !== b && $("#PendingOrdersSales").text(b),
                    0 !== C && $("#DepositSales").text(C),
                    P.reverse(),
                    M.reverse(),
                    L.reverse();
                for (let e = 0; e < y.length; e++) {
                    for (let t = 0; t < n.length; t++) {
                        let a = new Date(n[t].fecha);
                        a.setDate(a.getDate());
                        let r = a.getDate() + "/" + (a.getMonth() + 1) + "/" + a.getFullYear();
                        y[e] == r && 3 == n[t].state_order_id && ((w += parseFloat(n[t].total)), (F[y[e]] = w));
                    }
                    w = 0;
                }
                for (var z = Object.values(F), q = 0; q < z.length; q++) var G = z[0], J = z[1];
                if ("" == G || null == G || null == G) var V = (O = 100 * ((G = 0) / J - 1)).toFixed() + "%";
                else V = (O = 100 * (G / J - 1)).toFixed() + "%";
                if (O <= 0)
                    $(".percentage").text(V),
                        document.querySelector(".percentage").style.setProperty("color", "red"),
                        $(".percentage").each(function () {
                            $(this).append('<i class="fas fa-arrow-down"></i>');
                        });
                else if (O > 0)
                    $(".percentage").text(V),
                        document.querySelector(".percentage").style.setProperty("color", "green"),
                        $(".percentage").each(function () {
                            $(this).append('<i class="fas fa-arrow-up"></i>');
                        });
                else if (isNaN(O)) {
                    $(".percentage").text("No se registran ventas hoy");
                    let e = document.querySelector(".percentage");
                    e.style.setProperty("opacity", "0.5"), e.style.setProperty("font-size", "0.85em");
                }
                let W = 0;
                var Z = 0;
                !(function () {
                    for (let e = 0; e < s.length; e++) {
                        for (let t = 0; t < r.length; t++) if (3 == r[t].state_order_id) for (let a = 0; a < r[t].order_items.length; a++) s[e].id == r[t].order_items[a].product_id && (W++, (T[[s[e].id]] = W));
                        W = 0;
                    }
                    Object.values(T).forEach(function (e) {
                        Z += e;
                    });
                })(),
                    (j = -1);
                var K = Object.values(T);
                for (let e = 0; e < K.length; e++) {
                    j++;
                    var X = document.getElementById("insertTD-" + j),
                        H = (K[e] / Z) * 100,
                        Q = H.toFixed(2) + "%",
                        ee = document.createElement("td");
                    H >= 20
                        ? ($(ee).each(function () {
                              $(this).append('<i class="text-success fas fa-arrow-up"></i>'), $(this).append('<small style="font-size: .85em;" class="text-success mr-1" id="percentSales">' + Q + "</small>"), $(this).append("Sold");
                          }),
                          X.appendChild(ee))
                        : H <= 20
                        ? ($(ee).each(function () {
                              $(this).append('<i class="text-danger fas fa-arrow-down"></i>'), $(this).append('<small style="font-size: .85em;" class="text-danger mr-1" id="percentSales">' + Q + "</small>"), $(this).append("Sold");
                          }),
                          X.appendChild(ee))
                        : ("" != H && 0 != H) ||
                          ($(ee).each(function () {
                              $(this).append('<i class="text-danger fas fa-arrow-down"></i>'), $(this).append('<small style="font-size: .85em;" class="text-danger mr-1" id="percentSales">0%</small>'), $(this).append("Sold");
                          }),
                          X.appendChild(ee));
                }
                let te = 0;
                var ae = 0;
                !(function () {
                    for (let e = 0; e < r.length; e++) {
                        if (3 == r[e].state_order_id) for (let t = 0; t < r[e].order_items.length; t++) r[e].id == r[e].order_items[t].order_id && (te++, (k["Pedido #" + [r[e].id]] = te));
                        te = 0;
                    }
                    for (let e = 0; e < r.length; e++) if (3 == r[e].state_order_id) for (let t = 0; t < r[e].order_items.length; t++) ae++;
                })();
                var re = Object.values(k),
                    ne = 0;
                for (let e = 0; e < re.length; e++) 1 == re[e] && ne++;
                var se = (ne / ae) * 100,
                    oe = se.toFixed(2) + "%",
                    ie = document.getElementById("percentOne"),
                    de = document.createElement("span"),
                    le = document.createElement("span");
                isNaN(se)
                    ? ($(de).each(function () {
                          $(this).attr("class", "font-weight-bold"), $(this).append('<i class="ion ion-android-arrow-up text-danger"> </i> '), $(this).append("0%");
                      }),
                      $(le).each(function () {
                          $(this).attr("class", "text-muted"), $(this).append("1 PRODUCTO");
                      }),
                      ie.appendChild(de),
                      ie.appendChild(le))
                    : ($(de).each(function () {
                          $(this).attr("class", "font-weight-bold"), $(this).append('<i class="ion ion-android-arrow-up text-danger"> </i> '), $(this).append(oe);
                      }),
                      $(le).each(function () {
                          $(this).attr("class", "text-muted"), $(this).append("1 PRODUCTO");
                      }),
                      ie.appendChild(de),
                      ie.appendChild(le));
                var ce = Object.values(k),
                    pe = 0;
                for (let e = 0; e < ce.length; e++) re[e] >= 2 && re[e] <= 3 && pe++;
                var he = (pe / ae) * 100,
                    fe = he.toFixed(2) + "%",
                    ge = document.getElementById("percentTwo"),
                    ue = document.createElement("span"),
                    $e = document.createElement("span");
                isNaN(he)
                    ? ($(ue).each(function () {
                          $(this).attr("class", "font-weight-bold"), $(this).append('<i class="ion ion-android-arrow-up text-warning"> </i> '), $(this).append("0%");
                      }),
                      $($e).each(function () {
                          $(this).attr("class", "text-muted"), $(this).append("2 a 3 PRODUCTOS");
                      }),
                      ge.appendChild(ue),
                      ge.appendChild($e))
                    : ($(ue).each(function () {
                          $(this).attr("class", "font-weight-bold"), $(this).append('<i class="ion ion-android-arrow-up text-warning"> </i> '), $(this).append(fe);
                      }),
                      $($e).each(function () {
                          $(this).attr("class", "text-muted"), $(this).append("2 a 3 PRODUCTOS");
                      }),
                      ge.appendChild(ue),
                      ge.appendChild($e));
                var xe = Object.values(k),
                    me = 0;
                for (let e = 0; e < xe.length; e++) re[e] >= 4 && me++;
                var _e = (me / ae) * 100,
                    ve = _e.toFixed(2) + "%",
                    be = document.getElementById("percentThree"),
                    Ce = document.createElement("span"),
                    De = document.createElement("span");
                isNaN(_e)
                    ? ($(Ce).each(function () {
                          $(this).attr("class", "font-weight-bold"), $(this).append('<i class="ion ion-android-arrow-up text-success"> </i> '), $(this).append("0%");
                      }),
                      $(De).each(function () {
                          $(this).attr("class", "text-muted"), $(this).append("+4 PRODUCTOS");
                      }),
                      be.appendChild(Ce),
                      be.appendChild(De))
                    : ($(Ce).each(function () {
                          $(this).attr("class", "font-weight-bold"), $(this).append('<i class="ion ion-android-arrow-up text-success"> </i> '), $(this).append(ve);
                      }),
                      $(De).each(function () {
                          $(this).attr("class", "text-muted"), $(this).append("+4 PRODUCTOS");
                      }),
                      be.appendChild(Ce),
                      be.appendChild(De));
                var Oe = $("#visitors-chart");
                new Chart(Oe, {
                    data: {
                        labels: P,
                        datasets: [
                            { type: "line", data: M, backgroundColor: "transparent", borderColor: "#007bff", pointBorderColor: "#007bff", pointBackgroundColor: "#007bff", fill: !1 },
                            { type: "line", data: L, backgroundColor: "tansparent", borderColor: "#ffffff", pointBorderColor: "#ffffff", pointBackgroundColor: "#ffffff", fill: !1 },
                        ],
                    },
                    options: {
                        maintainAspectRatio: !1,
                        tooltips: { mode: "index", intersect: !0 },
                        hover: { mode: "index", intersect: !0 },
                        legend: { display: !1 },
                        scales: {
                            yAxes: [
                                {
                                    gridLines: { display: !0, lineWidth: "4px", color: "rgba(0, 0, 0, .2)", zeroLineColor: "transparent" },
                                    ticks: $.extend(
                                        {
                                            beginAtZero: !0,
                                            callback: function (e) {
                                                return parseInt(e) >= 1e3 ? "$" + e.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") : "$" + e;
                                            },
                                            suggestedMax: a,
                                        },
                                        e
                                    ),
                                },
                            ],
                            xAxes: [{ display: !0, gridLines: { display: !1 }, ticks: e }],
                        },
                    },
                });
            },
        });
});
