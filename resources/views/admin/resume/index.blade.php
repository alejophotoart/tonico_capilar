@extends('admin.layout') @section('title', __('Resumen')) @section('titleSup',
__('Resumen')) @section('content')
<div class="row">
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3 id="toggleNewOrder"></h3>

          <p>{{__('Pedidos Nuevos')}}</p>
        </div>
        <div class="icon">
            <i class="fas fa-list-ol"></i>
        </div>
        <a href="{{ route('orders.index') }}" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-success">
        <div class="inner">
          <h3 id="toggleDeliveredOrder"></h3>

          <p>Pedidos Entregados</p>
        </div>
        <div class="icon">
            <i class="fas fa-shopping-bag"></i>
        </div>
        <a href="{{ route('orders.tables.delivered') }}" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-warning">
        <div class="inner">
          <h3 id="toggleProcessOrder"></h3>

          <p>Pedidos en Proceso</p>
        </div>
        <div class="icon">
            <i class="fas fa-truck"></i>
        </div>
        <a href="{{ route('orders.tables.in-progress') }}" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-danger">
        <div class="inner">
          <h3 id="toggleCancelOrder"></h3>

          <p>Pedidos Cancelados</p>
        </div>
        <div class="icon">
            <i class="fas fa-ban"></i>
        </div>
        <a href="{{ route('orders.tables.canceled') }}" class="small-box-footer">Más info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div>
  <!-- /.row -->
<div class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                {{-- Grafico de ventas a lo largo de la semana que indica si se vendio mas que ayer--}}
                <div class="card">
                    <div class="card-header border-0">
                            <h3 class="card-title">
                                Estadisticas de ventas
                            </h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg" id="quantity_sales"></span>
                                <span>Pedidos registrados totales</span>
                            </p>
                            <p class="ml-auto d-flex flex-column text-right">
                                <span class="percentage">

                                </span>
                                <span class="text-muted"
                                    >Comparacion de ayer</span
                                >
                            </p>
                        </div>
                        <!-- /.d-flex -->

                        <div class="position-relative mb-4">
                            <canvas id="visitors-chart" height="200"></canvas>
                        </div>

                        <div class="d-flex flex-row justify-content-end">
                            <span class="mr-2">
                                <i class="fas fa-square text-primary"></i> Total de ventas
                            </span>

                            <span>
                                <i class="fas fa-square text-gray"></i> Cantidad de ventas
                            </span>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
                {{-- Tabla de productos que indica el porcetaje de ventas de cada producto --}}
                @include('admin.resume.percentProducts')
                <!-- /.card -->



            </div>
            <!-- /.col-md-6 -->
            <div class="col-lg-6">
                {{-- Tabla de ventas que indica el total vendido el dia de hoy y anteriores dias --}}
                @include('admin.resume.percentSalesToday')
                <!-- /.card -->
                {{-- Tabla de mensajes de whatsApp publicidad --}}
                @include('admin.resume.countMessagesWhatsApp')
                <!-- /.card -->
                {{-- Tabla de ventas que indica el total vendido de productos por paquetes --}}
                @include('admin.resume.percentSalesforPack')
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/adminlte/js/pages/dashboard3.js"></script>
<script src="/adminlte/js/resumen/filterForDate.js"></script>
<script>
    $( function() {
        var date = new Date();
        var year = date.getFullYear();
        let finalDate = date.getFullYear()+'-'+ (date.getMonth()+1) +'-'+date.getDate();
        let dateFormat = date.getFullYear()+'-'+ (date.getMonth()+1) +'-'+date.getDate();
        document.getElementById("datepicker").value = dateFormat;

        var start = new Date();
        start.setFullYear(start.getFullYear()-5);
        var startf = start.toISOString().slice(0,10).replace(/-/g,"/");

        $( "#datepicker" ).datepicker({
            firstDay: 1,
            dateFormat: 'yy-mm-dd',
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
            yearRange: startf + ":" + year,
            maxDate: new Date(finalDate),
        });
    });
</script>
@endsection
