@extends('admin.layout') @section('title', __('Productos x Bodega')) @section('titleSup',
__('Productos x Bodega')) @section('explorer')
<li class="breadcrumb-item active">
    {{ __("Productos x Bodega") }}
</li>
@endsection @section('content')
<div class="content" style="text-align: center;">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">{{ __("Lista de productos x bodega") }}</h1>
            @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
            <div class="float-end">
                <a href="#"
                    ><button class="btn btn-dark" type="button">
                        <i class="fas fa-plus"></i></button
                ></a>
            </div>
            @endif
        </div>
        <div class="card-body">
            <table
                class="table table-striped"
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
                            {{ __("Product") }}
                        </th>
                        <th>
                            {{ __("Warehouse") }}
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
                    @foreach ($product_warehouses as $pw)
                    <tr>
                        <td>
                            {{ $pw->id }}
                        </td>
                        @foreach ($pw->products as $pwp)
                            @if($pwp->id == $pw->product_id)
                                <td>
                                    {{ $pwp->name }} <br />
                                </td>
                            @endif

                        <td>
                            @foreach ($pw->warehouses as $pww)
                                @if($pww->id == $pw->warehouse_id)
                                    {{$pww->name}} <br />
                                @endif

                        </td>
                        <td>
                            {{ $pw->quantity }}
                        </td>
                        <td>
                            <p style="opacity: 0.6; font-size: 0.8em;">
                                Ajustado
                                {{ $pw->updated_at->diffForHumans() }}
                            </p>
                        </td>
                        @if(auth()->user()->role_id == 1 ||
                        auth()->user()->role_id == 2)
                        <td>
                            <a
                                onclick="editProductWarehouse({{ $pw->id }})"
                                class="mg-10"
                            >
                                <i id="IconE" class="fas fa-pencil-alt"></i>
                            </a>
                            <a
                                class="mg-10"
                                onclick="deleteProductWarehouse('{{$pw->id}}', '{{$pww->name}}', '{{ $pwp->name }}')"
                            >
                                <i id="IconD" class="fas fa-trash-alt"></i>
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
