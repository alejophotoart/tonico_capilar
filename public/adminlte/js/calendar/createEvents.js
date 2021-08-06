function addEventCalendar() {
    $("#addEventCalendarModal").modal("show")
}

function addEvents(user_id) {
    var title = document.getElementById("title").value;
    var start = document.getElementById("datepicker_start").value;
    var end = document.getElementById("datepicker_end").value;
    var time = document.getElementById("datepicker_time").value;
    if ($('#checkFullDay').is(":checked")) {
        var fullDay = true;
      }
      else{
          var fullDay=false;
      }

      if (title == 0 || title == "") {
        Swal.fire({
            icon: "info",
            title: "Sin titulo",
            text: "El campo titulo se encuentra vacio",
            confirmButtonColor: "#343a40",
            showConfirmButton: true
        });
        return false;
    } else {
        Swal.fire({
            title: "Estas seguro?",
            text: "Deseas crear el evento " + title,
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#343a40",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, Crearlo!",
            cancelButtonText: "Cancelar"
        }).then(result => {
            if (result.isConfirmed) {
                let data = {
                    title,
                    start,
                    end,
                    time,
                    fullDay,
                    user_id
                };
                console.log(data);
                let timerInterval;
                Swal.fire({
                    title: "Creando evento",
                    didOpen: () => {
                        Swal.showLoading();

                        timerInterval = setInterval(() => {
                            const content = Swal.getHtmlContainer();
                            if (content) {
                                const b = content.querySelector(
                                    "b"
                                );
                                if (b) {
                                    b.textContent = Swal.getTimerLeft();
                                }
                            }
                        }, 100);
                    }
                });
                $.ajax({
                    url: "/calendar/create_event",
                    type: "POST",
                    data: JSON.stringify(data),
                    contentType: "application/json",
                    dataType: "json",
                    headers: {
                        "X-CSRF-TOKEN": $(
                            'meta[name="csrf-token"]'
                        ).attr("content")
                    },
                    //data: obj.json.strin,
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
                                confirmButtonColor:
                                    "#343a40",
                                showConfirmButton: true
                            }).then(val => {
                                $(location).attr(
                                    "href",
                                    "/calendario"
                                );
                            });
                        } else {
                            if (r["status"] == 100) {
                                Swal.fire({
                                    icon: r["icon"],
                                    title: r["title"],
                                    text: r["message"]
                                });
                                return false;
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: "Ops...",
                                    text:
                                        "Ocurrio un error inesperado"
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

