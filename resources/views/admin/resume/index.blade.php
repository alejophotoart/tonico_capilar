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
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">
                                Estadisticas de ventas
                            </h3>
                        </div>
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

                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">{{ __("Products") }}</h3>
                        <div class="card-tools">
                            <a href="#" class="btn btn-tool btn-sm">
                                <i class="fas fa-download"></i>
                            </a>
                            <a href="#" class="btn btn-tool btn-sm">
                                <i class="fas fa-bars"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-striped table-valign-middle">
                            <thead>
                                <tr>
                                    <th>{{ __("Producto") }}</th>
                                    <th>{{ __("Price") }}</th>
                                    <th>{{ __("% de venta") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @for ($i = 0; $i < count($products); $i++)
                                <tr id="insertTD-{{ $i }}">
                                    <td>
                                        @if($products[$i]->img !== null)
                                        <img
                                            src="{{$products[$i]->link}}{{$products[$i]->img}}"
                                            alt="{{$products[$i]->name}}"
                                            class="img-circle img-size-32 mr-2"
                                        />
                                        {{$products[$i]->name}}
                                        @else
                                        <img
                                            src="/adminlte/img/products/default.png"
                                            alt="{{$products[$i]->name}}"
                                            class="img-circle img-size-32 mr-2"
                                        />
                                        {{$products[$i]->name}}
                                        @endif
                                    </td>
                                    <td>
                                        {{ "$" }}
                                        {{ number_format($products[$i]->price, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card -->

            </div>
            <!-- /.col-md-6 -->
            <div class="col-lg-6">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="d-flex justify-content-between">
                            <h3 class="card-title">{{ __("Publicidad") }}</h3>
                        </div>
                    </div>
                    <div class="card-body table-responsive p-0">
                        <table class="table table-striped table-valign-middle">
                            <thead>
                                <tr>
                                    <th colspan="4">{{ __("Mesajes") }}</th>
                                </tr>
                                <tr>
                                    <th>{{ __("M1") }}</th>
                                    <th>{{ __("M6") }}</th>
                                    <th>{{ __("B1") }}</th>
                                    <th>{{ __("B6") }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>6</td>
                                    <td>14</td>
                                    <td>28</td>
                                    <td>18</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.card -->

                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">
                            Ventas por producto
                        </h3>
                        <div class="card-tools">
                            <a href="#" class="btn btn-sm btn-tool">
                                <i class="fas fa-download"></i>
                            </a>
                            <a href="#" class="btn btn-sm btn-tool">
                                <i class="fas fa-bars"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div
                            class="d-flex justify-content-between align-items-center border-bottom mb-3"
                        >
                            <p class="text-danger text-xl">
                                <i class="fas fa-shopping-bag"></i>
                            </p>
                            <p class="d-flex flex-column text-right" id="percentOne">

                            </p>
                        </div>
                        <!-- /.d-flex -->
                        <div
                            class="d-flex justify-content-between align-items-center border-bottom mb-3"
                        >
                            <p class="text-warning text-xl">
                                <i class="fas fa-shopping-bag"></i>
                            </p>
                            <p class="d-flex flex-column text-right" id="percentTwo">

                            </p>
                        </div>
                        <!-- /.d-flex -->
                        <div
                            class="d-flex justify-content-between align-items-center mb-0"
                        >
                            <p class="text-success text-xl">
                                <i class="fas fa-shopping-bag"></i>
                            </p>
                            <p class="d-flex flex-column text-right" id="percentThree">

                            </p>
                        </div>
                        <!-- /.d-flex -->
                    </div>
                </div>
            </div>
            <!-- /.col-md-6 -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="/adminlte/js/pages/dashboard3.js"></script>
@endsection
