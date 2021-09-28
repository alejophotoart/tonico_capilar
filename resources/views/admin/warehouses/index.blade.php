@extends('admin.layout') @section('title', __('Warehouses')) @section('titleSup',
__('Warehouses')) @section('explorer')
<li class="breadcrumb-item active">
    {{ __("Warehouses") }}
</li>
@endsection @section('content')
<div class="content" style="text-align: center;">
    <div class="card">
        <div class="card-header darkMode-bbg">
            <h1 class="card-title">{{ __("Lista de bodegas") }}</h1>
            @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
            <div class="float-end">
                <a onclick="ShowModalCreateWarehouse()">
                    <button class="btn btn-dark" type="button">
                        <i class="fas fa-plus"></i></button
                ></a>
            </div>
            @endif
        </div>
        <div class="card-body darkMode-bbg">
            <table
                class="table table-responsive-xl"
                style="width:100%"
                id="tablewarehouses"
            >
                <thead>
                    <tr>
                        <th>
                            {{ __("ID") }}
                        </th>
                        <th>
                            {{ __("Nombre Bodega") }}
                        </th>
                        <th>
                            {{ __("Ubicacion") }}
                        </th>
                        <th>
                            {{ __("Estado") }}
                        </th>
                        @if(auth()->user()->role_id == 1 ||
                        auth()->user()->role_id == 2)
                        <th>
                            {{ __("Actions") }}
                        </th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($warehouses as $w)
                    <tr>
                        <td class="darkMode-fill">
                            {{ $w->id }}
                        </td>

                        <td class="darkMode-fill">
                            {{ $w->name }}
                        </td>
                        <td class="darkMode-fill">
                            {{ $w->city->state->country->name }} <br />
                            {{ $w->city->state->name }} <br />
                            {{ $w->city->name }}
                        </td>
                        <td class="darkMode-fill">
                            @if($w->state_warehouse_id == 1)
                                <span class="right badge badge-success"
                                    >Activa</span
                                >

                                @else @if($w->state_warehouse_id == 2)

                                <span class="right badge badge-danger"
                                    >Inactiva</span
                                >
                                @endif
                            @endif
                        </td>
                        @if(auth()->user()->role_id == 1 ||
                            auth()->user()->role_id == 2)
                        <td class="darkMode-fill" id="actions">
                            <a
                                data-toggle="tooltip"
                                title="Editar"
                                onclick="editWarehouses( {{ $w->id }}, {{ $w->state_warehouse_id }}, {{ $w->city->state->country->id }}, {{$w->city->id}}, {{ $w->city->state->id }})"
                                class="mg-10"
                            >
                                <i id="IconE" class="fas fa-pencil-alt darkMode-icon"></i>
                            </a>
                            <a
                                data-toggle="tooltip"
                                title="Eliminar"
                                class="mg-10"
                                onclick="deleteWarehouse('{{$w->id}}', '{{$w->name}}')"
                            >
                                <i id="IconD" class="fas fa-trash-alt darkMode-icon"></i>
                            </a>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="/adminlte/js/warehouses/showDataTable.js"></script>
<script src="/adminlte/js/warehouses/deleteWarehouses.js"></script>
@include('admin.warehouses.create') @include('admin.warehouses.edit')@endsection
