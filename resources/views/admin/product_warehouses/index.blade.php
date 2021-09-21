@extends('admin.layout') @section('title', __('Productos x Bodega')) @section('titleSup',
__('Productos x Bodega')) @section('explorer')
<li class="breadcrumb-item active">
    {{ __("Productos x Bodega") }}
</li>
@endsection @section('content')
<div class="content" style="text-align: center;">
    <div class="card">
        <div class="card-header darkMode-bbg">
            <h1 class="card-title">{{ __("Lista de productos x bodega") }}</h1>
            @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)

            @endif
        </div>
        <div class="card-body darkMode-bbg">
            <table
                class="table table-responsive-sm"
                style="width:100%"
                id="tableProductWarehouses"
            >
                <thead>
                    <tr>
                        <th>
                            <i
                                class="fas fa-key"
                                style="margin-right: 5px;"
                            ></i>
                        </th>
                        <th>
                            {{ __("Producto") }}
                        </th>
                        <th>
                            {{ __("Bodega") }}
                        </th>
                        <th>
                            {{ __("Quantity") }}
                        </th>
                        <th>
                            {{__('Ultimo ajuste')}}
                        </th>
                        @if(auth()->user()->role_id == 1 ||
                        auth()->user()->role_id == 2 )
                        <th>
                            {{ __("Actions") }}
                        </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    {{-- {{dd($product_warehouses)}} --}}
                    @foreach ($product_warehouses as $pw)
                    <tr>
                        <td class="darkMode-fill">
                            {{ $pw->id }}
                        </td>

                        <td class="darkMode-fill">
                            @foreach ($pw->products as $pwp)
                            {{ $pwp->name }}
                        </td>
                        <td class="darkMode-fill">
                            @foreach ($pw->warehouses as $pww)
                            {{$pww->name}}
                        </td>
                        <td class="darkMode-fill">
                            @if($pw->quantity <= 0)
                                <p class="text-danger">{{ $pw->quantity }}<br>
                                    No hay unidades disponibles
                                </p>
                            @else
                                @if($pw->quantity <= 10)
                                    <p class="text-warning">{{ $pw->quantity }}<br>
                                        Quedan pocas unidades
                                    </p>
                                @else
                                <p class="text-success">{{ $pw->quantity }}<br>
                                    Unidades
                                </p>
                                @endif
                            @endif
                        </td>
                        <td class="darkMode-fill">
                            <p style="opacity: 0.6; font-size: 0.8em;">
                                Ajustado
                                {{ $pw->updated_at->diffForHumans() }}
                            </p>
                        </td>
                        @if(auth()->user()->role_id == 1 ||
                        auth()->user()->role_id == 2)
                        <td class="darkMode-fill">
                            <a
                                onclick="editProductWarehouse({{ $pw->id }}, {{ $pww->id }})"
                                class="mg-10"
                            >
                                @if($pw->quantity <= 0)
                                    <i id="IconE" class="fas fa-pencil-alt darkMode-icon"></i>
                                @else
                                    <i id="IconE" class="fas fa-plus darkMode-icon"></i>
                                @endif
                            </a>
                            <a
                                class="mg-10"
                                onclick="deleteProductWarehouse('{{$pw->id}}', '{{$pww->name}}', '{{ $pwp->name }}', '{{ $pwp->id }}')"
                            >
                                <i id="IconD" class="fas fa-trash-alt darkMode-icon"></i>
                            </a>
                        </td>
                        @endif
                    </tr>
                        @endforeach
                    @endforeach
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="/adminlte/js/productWarehouses/DataTableProductWarehouses.js"></script>
<script src="/adminlte/js/productWarehouses/editProductWarehouses.js"></script>
<script src="/adminlte/js/productWarehouses/deleteProductwarehouses.js"></script>
@include('admin.product_warehouses.edit') @endsection
