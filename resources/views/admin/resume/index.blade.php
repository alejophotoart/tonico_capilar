@extends('admin.layout') @section('title', __('Resumen')) @section('titleSup',
__('Resumen')) @section('content')
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
                                <span>Ventas a lo largo del tiempo</span>
                            </p>
                            <p class="ml-auto d-flex flex-column text-right">
                                <span class="text-success">
                                    <i class="fas fa-arrow-up"></i> 12.5%
                                </span>
                                <span class="text-muted"
                                    >Desde la semana pasada</span
                                >
                            </p>
                        </div>
                        <!-- /.d-flex -->

                        <div class="position-relative mb-4">
                            <canvas id="visitors-chart" height="200"></canvas>
                        </div>

                        <div class="d-flex flex-row justify-content-end">
                            <span class="mr-2">
                                <i class="fas fa-square text-primary"></i> Esta
                                semana
                            </span>

                            <span>
                                <i class="fas fa-square text-gray"></i> Ultima
                                semana
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
                                    <th>{{ __("Ventas") }}</th>
                                    <th>More</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $p)
                                <tr>
                                    <td>
                                        @if($p->img !== null)
                                        <img
                                            src="{{$p->link}}{{$p->img}}"
                                            alt="{{$p->name}}"
                                            class="img-circle img-size-32 mr-2"
                                        />
                                        {{$p->name}}
                                        @else
                                        <img
                                            src="/adminlte/img/products/default.png"
                                            alt="{{$p->name}}"
                                            class="img-circle img-size-32 mr-2"
                                        />
                                        {{$p->name}}
                                        @endif
                                    </td>
                                    <td>
                                        {{ "$" }}
                                        {{ number_format($p->price, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <small class="text-success mr-1">
                                            <i class="fas fa-arrow-up"></i>
                                            12%
                                        </small>
                                        Sold
                                    </td>
                                    <td>
                                        <a href="#" class="text-muted">
                                            <i class="fas fa-search"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
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
                            <h3 class="card-title">{{ __("Ventas") }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex">
                            <p class="d-flex flex-column">
                                <span class="text-bold text-lg"
                                    >$18,230.00</span
                                >
                                <span>Ventas a lo largo del tiempo</span>
                            </p>
                            <p class="ml-auto d-flex flex-column text-right">
                                <span class="text-success">
                                    <i class="fas fa-arrow-up"></i> 33.1%
                                </span>
                                <span class="text-muted"
                                    >Desde el mes pasado</span
                                >
                            </p>
                        </div>
                        <!-- /.d-flex -->

                        <div class="position-relative mb-4">
                            <canvas id="sales-chart" height="200"></canvas>
                        </div>

                        <div class="d-flex flex-row justify-content-end">
                            <span class="mr-2">
                                <i class="fas fa-square text-primary"></i> Este
                                año
                            </span>

                            <span>
                                <i class="fas fa-square text-gray"></i> Ultimo
                                año
                            </span>
                        </div>
                    </div>
                </div>
                <!-- /.card -->

                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="card-title">
                            Descripción general de la tienda en línea
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
                            <p class="text-success text-xl">
                                <i class="ion ion-ios-refresh-empty"></i>
                            </p>
                            <p class="d-flex flex-column text-right">
                                <span class="font-weight-bold">
                                    <i
                                        class="ion ion-android-arrow-up text-success"
                                    ></i>
                                    12%
                                </span>
                                <span class="text-muted"
                                    >TASA DE CONVERSIÓN</span
                                >
                            </p>
                        </div>
                        <!-- /.d-flex -->
                        <div
                            class="d-flex justify-content-between align-items-center border-bottom mb-3"
                        >
                            <p class="text-warning text-xl">
                                <i class="ion ion-ios-cart-outline"></i>
                            </p>
                            <p class="d-flex flex-column text-right">
                                <span class="font-weight-bold">
                                    <i
                                        class="ion ion-android-arrow-up text-warning"
                                    ></i>
                                    0.8%
                                </span>
                                <span class="text-muted">TASA DE VENTAS</span>
                            </p>
                        </div>
                        <!-- /.d-flex -->
                        <div
                            class="d-flex justify-content-between align-items-center mb-0"
                        >
                            <p class="text-danger text-xl">
                                <i class="ion ion-ios-people-outline"></i>
                            </p>
                            <p class="d-flex flex-column text-right">
                                <span class="font-weight-bold">
                                    <i
                                        class="ion ion-android-arrow-down text-danger"
                                    ></i>
                                    1%
                                </span>
                                <span class="text-muted"
                                    >TASA DE EMPLEADOS</span
                                >
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
