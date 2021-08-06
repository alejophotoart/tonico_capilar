<div class="modal fade" id="addEventCalendarModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Crear Evento</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="card">
                <h6 class="card-header">Calendario
                    <span class="far fa-calendar-plus"></span>
                    </h6>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                  <label for="" class="form-label">{{__("Titulo del Evento")}}</label>
                                  <input
                                      type="text"
                                      class="form-control"
                                      placeholder="Titulo del eveto"
                                      id="title"
                                      name="title"
                                      />
                                </div>
                             </div>
                           <div class="row" style="margin-top: 20px;">
                              <div class="col-md-12">
                                <label for="" class="form-label">{{__("Fecha de Inicio")}}</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Fecha de Inicio"
                                    id="datepicker_start"
                                    name="datepicker_start"
                                />
                              </div>
                           </div>
                        <div class="row" style="margin-top: 20px;">
                            <div class="col-md-12">
                              <label for="" class="form-label">{{__("Fecha de Final")}}</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Fecha de Final"
                                id="datepicker_end"
                                name="datepicker_end"
                                disabled
                            />
                        </div>
                    </div>
                    <div class="row" style="margin-top: 20px;" id="disableObject">
                        <div class="col-md-12">
                          <label for="" class="form-label">{{__("Hora del Evento")}}</label>
                        <input
                            type="time"
                            class="form-control"
                            placeholder="Hora del Evento"
                            id="datepicker_time"
                            name="datepicker_time"
                        />
                    </div>
                </div>
                    <div class="row" style="margin-top: 20px;">
                        <div class="col-md-12" id="typeCheckBox">
                          <label for="" class="form-label">{{__("Todo el dia")}}</label>
                          <br>
                        <input
                            type="checkbox"
                            id="checkFullDay"
                            name="checkFullDay"
                        />
                    </div>
                </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-dark" onclick="addEvents({{auth()->user()->id}})">Crear</button>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    function minTwoDigits(n) {
        return (n < 10 ? "0" : "") + n;
    }
    $( function() {
        $("#datepicker_start").click(function(){
            $("#datepicker_end").prop("disabled", false);
        });

        var date = new Date();
        var year = date.getFullYear();
        let finalDate = date.getFullYear()+'-'+ (date.getMonth()+1) +'-'+date.getDate();
        let dateFormat = date.getFullYear()+'/'+ (date.getMonth()+1) +'/'+date.getDate();
        document.getElementById("datepicker_start").value = dateFormat;
        document.getElementById("datepicker_end").value = dateFormat;

        var time = new Date();
        var hora = time.getHours(); //obteniendo hora
        var minutos = time.getMinutes(); //obteniendo minuto
        document.getElementById("datepicker_time").value =
        minTwoDigits(hora) +":" + minTwoDigits(minutos);

        var start = new Date();
        start.setFullYear(start.getFullYear()+5);
        var startf = start.toISOString().slice(0,10).replace(/-/g,"/");

        $( "#datepicker_start" ).datepicker({
            firstDay: 1,
            dateFormat: 'yy/mm/dd',
            dayNamesMin: [ "Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab" ],
            dayNames: [ "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" ],
            showOtherMonths: true,
            monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
            showAnim: "fold",
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true,
            gotoCurrent: true,
            currentText: "Hoy",
            closeText: "Cerrar",
            monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ],
            yearRange: year + ":" + startf,
            minDate: new Date(finalDate),
        });

        $( "#datepicker_end" ).datepicker({
            firstDay: 1,
            dateFormat: 'yy/mm/dd',
            dayNamesMin: [ "Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab" ],
            dayNames: [ "Domingo", "Lunes", "Martes", "Miercoles", "Jueves", "Viernes", "Sabado" ],
            showOtherMonths: true,
            monthNames: [ "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ],
            showAnim: "fold",
            showButtonPanel: true,
            changeMonth: true,
            changeYear: true,
            gotoCurrent: true,
            currentText: "Hoy",
            closeText: "Cerrar",
            monthNamesShort: [ "Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic" ],
            yearRange: year + ":" + startf,
            minDate: new Date(finalDate),
        });

        $("#typeCheckBox input[type=checkbox]").click(function() {
            if (this.checked) {
                let element = document.querySelector("#disableObject");
                    element.style.setProperty("display", "none");
                $("#datepicker_time").val("");
            }else{
                if(this.checked == false){
                    let element = document.querySelector("#disableObject");
                    element.style.setProperty("display", "flex");
                    document.getElementById("datepicker_time").value =
                    minTwoDigits(hora) +":" + minTwoDigits(minutos);
                }
            }
        });
    });
 </script>

