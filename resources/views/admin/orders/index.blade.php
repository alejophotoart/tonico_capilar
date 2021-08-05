@extends('admin.layout') @section('title', __('Orders')) @section('titleSup',
__('Orders')) @section('explorer')
<li class="breadcrumb-item active">
    {{ __("Orders") }}
</li>
@endsection @section('content')
<div class="card text-center">
    <div class="card-header" style="background-color: #edc800;">
        <ul class="nav nav-tabs card-header-tabs">
            <li class="nav-item">
                <a
                    href="{{ route('orders.index') }}"
                    class="nav-link active"
                    aria-current="true"
                    style="color: black;"
                    >{{ __("News") }}</a
                >
            </li>
            <li class="nav-item">
                <a
                    href="{{ route('orders.tables.in-progress') }}"
                    class="nav-link"
                    href="#"
                    style="color: black;"
                    >{{ __("In progress") }}</a
                >
            </li>
            <li class="nav-item">
                <a
                    href="{{ route('orders.tables.delivered') }}"
                    class="nav-link"
                    href="#"
                    style="color: black;"
                    >{{ __("Delivered") }}</a
                >
            </li>
            <li class="nav-item">
                <a
                    href="{{ route('orders.tables.canceled') }}"
                    class="nav-link"
                    href="#"
                    style="color: black;"
                    >{{ __("Canceled") }}</a
                >
            </li>
            @if(auth()->user()->role_id == 3)
            <li class="nav-item">
                <a
                    href="{{ route('orders.tables.deposit') }}"
                    class="nav-link"
                    href="#"
                    style="color: black;"
                    >{{ __("Deposito Aprobado") }}</a
                >
            </li>
            @else
                @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
            <li class="nav-item">
                <a
                    href="{{ route('orders.tables.deposit') }}"
                    class="nav-link"
                    href="#"
                    style="color: black;">
                    {{ __("Deposito Pendiente") }}
                </a>
            </li>
                @else
                    <li class="nav-item">
                        <a
                            href="{{ route('orders.tables.deposit') }}"
                            class="nav-link"
                            href="#"
                            style="color: black;">
                            {{ __("Depositos") }}
                        </a>
                    </li>
                @endif
            @endif
            <li class="nav-item">
                <a
                    href="{{ route('orders.tables.pending') }}"
                    class="nav-link"
                    href="#"
                    style="color: black;">
                    {{ __("Reagendados") }}
                </a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="content" style="text-align: center;">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">
                        <i
                            class="fas fa-list-ol"
                            style="margin-right: 5px; font-size: 1.5em;"
                        ></i
                        >{{ __("Pedidos Nuevos") }}
                    </h1>
                    <div class="float-end">
                        <a
                            onclick="ShowCreateOrderModal('{{ auth()->user()->id }}')"
                            ><button class="btn btn-dark" type="button">
                                <i class="fas fa-plus"></i></button
                        ></a>
                    </div>
                </div>
                <div class="card-body">
                    <table
                        class="table table-striped table-responsive"
                        style="width:100%"
                        id="tableOrders"
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
                                    {{ __("Salesman") }}
                                </th>
                                <th>
                                    {{ __("Ubication") }}
                                </th>
                                <th>
                                    {{ __("Client") }}
                                </th>
                                <th>
                                    {{ __("Fecha entrega") }}
                                </th>
                                <th>
                                    {{ __("Total") }}
                                </th>
                                <th>
                                    <i
                                        class="fas fa-cogs"
                                        style="margin-right: 5px;"
                                    ></i>
                                    {{ __("Actions") }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $o)
                            <tr>
                                <td>{{ $o->id }}</td>
                                <td style="width: 90px;">
                                    {{ $o->user->name }}
                                    <br />
                                    <p style="opacity: 0.6; font-size: 0.8em;">
                                        Creado
                                        {{ $o->created_at->diffForHumans() }}
                                    </p>
                                </td>
                                <td>
                                    {{ $o->city->state->country->name }} <br />
                                    {{ $o->city->state->name }} <br />
                                    {{ $o->city->name }}
                                </td>
                                <td style="width: 90px;">
                                    {{ $o->client->name }}
                                </td>
                                <td>{{ $o->delivery_date }}</td>
                                <td>
                                    {{ "$" }}
                                    {{ number_format($o->total, 0, ',', '.') }}
                                </td>
                                <td>
                                    @if(auth()->user()->role_id == 1 ||
                                    auth()->user()->role_id == 2)
                                    <a type="button" class="mg-10"
                                    href="{{ route('orders.edit', $o->id) }}">
                                        <i
                                            id="IconE"
                                            class="fas fa-pencil-alt"
                                            style="left: 1px;"
                                        ></i>
                                    </a>
                                    <a
                                        class="mg-10-0"
                                        onclick="CancelOrder('{{$o->id}}')"
                                    >
                                        <i id="IconD" class="fas fa-ban"></i>
                                    </a>
                                    <a
                                        onclick="ShowOrderModal( '{{ $o->id }}' )"
                                        data-bs-toggle="modal"
                                        data-bs-whatever="@fat"
                                        class="mg-10-1"
                                    >
                                        <i id="IconS" class="fas fa-eye"></i>
                                    </a>
                                    @else
                                    <a
                                        onclick="ShowOrderModal( '{{ $o->id }}' )"
                                        data-bs-toggle="modal"
                                        data-bs-whatever="@fat"
                                        class="mg-10-1"
                                    >
                                        <i id="IconS" class="fas fa-eye"></i>
                                    </a>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="/adminlte/js/orders/ShowTableOrder.js"></script>
<script src="/adminlte/js/orders/ModalCreate.js"></script>
<script src="/adminlte/js/orders/ModalShow.js"></script>
<script src="/adminlte/js/orders/ValidateCreateOrder.js"></script>
<script src="/adminlte/js/orders/CreateOrder.js"></script>
<script src="/adminlte/js/orders/CancelOrder.js"></script>
@include('admin.orders.create') @include('admin.orders.show') @endsection
