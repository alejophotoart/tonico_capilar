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
                    class="nav-link"
                    aria-current="true"
                    style="color: black;"
                    >{{ __("News") }}
                    @if(auth()->user()->role_id <> 4)
                        <span id="NewOrders" class="badge badge-danger"
                            ></span>
                    @else
                        <span id="NewOrdersSales" class="badge badge-danger"
                            ></span>
                    @endif</a
                >
            </li>
            <li class="nav-item">
                <a
                    href="{{ route('orders.tables.in-progress') }}"
                    class="nav-link"
                    href="#"
                    style="color: black;"
                    >{{ __("In progress") }}
                    @if(auth()->user()->role_id <> 4)
                        <span id="ProcessOrders" class="badge badge-danger"
                            ></span>
                    @else
                        <span id="ProcessOrdersSales" class="badge badge-danger"
                            ></span>
                    @endif</a
                >
            </li>
            <li class="nav-item">
                <a
                    href="{{ route('orders.tables.delivered') }}"
                    class="nav-link"
                    href="#"
                    style="color: black;"
                    >{{ __("Delivered") }}
                    @if(auth()->user()->role_id <> 4)
                        <span id="DeliveredOrders" class="badge badge-danger"
                        ></span>
                    @else
                        <span id="DeliveredOrdersSales" class="badge badge-danger"
                        ></span>
                    @endif</a
                >
            </li>
            <li class="nav-item">
                <a
                    href="{{ route('orders.tables.canceled') }}"
                    class="nav-link"
                    href="#"
                    style="color: black;"
                    >{{ __("Canceled") }}
                    @if(auth()->user()->role_id <> 4)
                        <span id="CancelOrders" class="badge badge-danger"
                        ></span>
                    @else
                        <span id="CancelOrdersSales" class="badge badge-danger"
                        ></span>
                    @endif</a
                >
            </li>
            @if(auth()->user()->role_id == 3)
            <li class="nav-item">
                <a
                    href="{{ route('orders.tables.deposit') }}"
                    class="nav-link active darkMode-nav"
                    href="#"
                    style="color: black;"
                    >{{ __("Deposito Aprobado") }}
                    <span id="PendingAprobationLogistic" class="badge badge-danger"
                        ></span></a
                >
            </li>
            @else
                @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
            <li class="nav-item">
                <a
                    href="{{ route('orders.tables.deposit') }}"
                    class="nav-link active darkMode-nav"
                    href="#"
                    style="color: black;">
                    {{ __("Deposito Pendiente") }}
                    <span id="PendingAprobationDeposit" class="badge badge-danger"
                        ></span>
                </a>
            </li>
                @else
                    <li class="nav-item">
                        <a
                            href="{{ route('orders.tables.deposit') }}"
                            class="nav-link active darkMode-nav"
                            href="#"
                            style="color: black;">
                            {{ __("Depositos") }}
                            <span id="DepositSales" class="badge badge-danger"
                            ></span>
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
                    @if(auth()->user()->role_id <> 4)
                         <span id="PendingOrders" class="badge badge-danger"
                        ></span>
                    @else
                         <span id="PendingOrdersSales" class="badge badge-danger"
                        ></span>
                    @endif
                </a>
            </li>
        </ul>
    </div>
    <div class="card-body darkMode">
        <div class="content" style="text-align: center;">
            <div class="card">
                <div class="card-header darkMode-bbg">
                    <h1 class="card-title">
                        <i
                        class="far fa-credit-card"
                            style="margin-right: 5px; font-size: 1.5em;"
                        ></i>
                        {{ __("Pedidos Pendientes (Deposito)") }}
                    </h1>
                    <div class="float-end">
                        <a
                            onclick="ShowCreateOrderModal('{{ auth()->user()->id }}')"
                            ><button class="btn btn-dark" type="button">
                                <i class="fas fa-plus"></i></button
                        ></a>
                    </div>
                </div>
                <div class="card-body darkMode-bbg">
                    <table
                        class="table table-responsive-lg"
                        style="width:100%"
                        id="tableOrders"
                    >
                        <thead>
                            <tr>
                                @if(auth()->user()->role_id == 1 ||
                                auth()->user()->role_id == 2 ||
                                auth()->user()->role_id == 3)
                                <th>
                                    <i
                                        class="fas fa-truck"
                                    ></i>
                                </th>
                                @endif
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
                                    {{ __("Fecha") }}
                                </th>
                                <th>
                                    {{ __("Phone") }}
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
                                @if(auth()->user()->role_id == 1 ||
                                auth()->user()->role_id == 2)
                                <td class="darkMode-fill" style="padding: 6px 0px 0px 0px;">
                                    <div class="form-check" id="formId">
                                        <input
                                            class="form-check-input checkOrder"
                                            type="checkbox"
                                            value="{{ $o->id }}"
                                            name="checkProgressOrder"
                                        />
                                    </div>
                                </td>
                                @else
                                    @if(auth()->user()->role_id == 3)
                                    <td class="darkMode-fill" style="padding: 6px 0px 0px 0px;">
                                        <div class="form-check" id="formPassed">
                                            <input
                                                class="form-check-input checkOrderPendingLogistic"
                                                type="checkbox"
                                                value="{{ $o->id }}"
                                                name="checkOrderPendingLogistic"
                                            />
                                        </div>
                                    </td>
                                    @endif
                                @endif
                                <td class="darkMode-fill" style="padding: 6px 0px 0px 0px;">
                                    {{ $o->id }}
                                </td>
                                <td class="darkMode-fill" style="width: 75px;">
                                    {{ $o->user->name }}
                                    <br />
                                    <p style="opacity: 0.6; font-size: 0.8em;">
                                        Creado
                                        {{ $o->created_at->diffForHumans() }}
                                        @if(auth()->user()->role_id == 3)
                                        <br>
                                        Aprobado
                                        {{ $o->updated_at->diffForHumans() }}
                                        @endif
                                    </p>
                                </td>
                                <td class="darkMode-fill">
                                    {{ $o->city->state->country->name }} <br />
                                    {{ $o->city->state->name }} <br />
                                    {{ $o->city->name }}
                                </td>
                                <td class="darkMode-fill" style="width: 75px;">
                                    {{ $o->client->name }}
                                </td>
                                <td class="darkMode-fill">{{ $o->delivery_date }}</td>
                                <td class="darkMode-fill">
                                    <i class="fas fa-mobile-alt"></i>
                                    {{ $o->client->phone }} <br />
                                    <i class="fab fa-whatsapp"></i>
                                    {{ $o->client->whatsapp }}
                                </td>
                                <td class="darkMode-fill">
                                    {{ "$" }}
                                    {{ number_format($o->total, 0, ',', '.') }}
                                </td>
                                <td class="darkMode-fill" style="padding: 5px 5px 5px 0px;">
                                    @if(auth()->user()->role_id == 1 ||
                                    auth()->user()->role_id == 2)
                                    <a class="mg-10"
                                        data-toggle="tooltip"
                                        title="Editar"
                                        href="{{ route('orders.edit', $o->id) }}">
                                        <i
                                            id="IconE"
                                            class="fas fa-pencil-alt darkMode-icon"
                                        ></i>
                                    </a>
                                    <a
                                        data-toggle="tooltip"
                                        title="Cancelar"
                                        class="mg-10-0"
                                        onclick="CancelOrder('{{$o->id}}')"
                                    >
                                        <i id="IconD" class="fas fa-ban darkMode-icon"></i>
                                    </a>
                                    <a
                                        data-toggle="tooltip"
                                        title="Mostra informacion"
                                        onclick="ShowOrderModal( '{{ $o->id }}' )"
                                        data-bs-toggle="modal"
                                        data-bs-whatever="@fat"
                                        class="mg-10-1"
                                        style="padding: 7px 5px 7px 5px !important;"
                                    >
                                        <i
                                            id="IconS"
                                            class="fas fa-eye darkMode-icon"
                                            style="position: relative; right: -2px;"
                                        ></i>
                                    </a>
                                    <a
                                        data-toggle="tooltip"
                                        title="Ver deposito"
                                        onclick="showVoucherCheck( '{{ $o->id }}' )"
                                        type="button"
                                        class="mg-10-1"
                                    >
                                        <i id="IconI" class="fas fa-image darkMode-icon"></i>
                                    </a>
                                    @else
                                        @if (auth()->user()->role_id == 3)
                                        <a class="mg-10"
                                            data-toggle="tooltip"
                                            title="Editar"
                                            href="{{ route('orders.edit', $o->id) }}">
                                            <i
                                                id="IconE"
                                                class="fas fa-pencil-alt darkMode-icon"
                                            ></i>
                                        </a>
                                        <a
                                            data-toggle="tooltip"
                                            title="Mostra informacion"
                                            onclick="ShowOrderModal( '{{ $o->id }}' )"
                                            data-bs-toggle="modal"
                                            data-bs-whatever="@fat"
                                            class="mg-10-1"
                                            style="padding: 7px 5px 7px 5px !important;"
                                        >
                                            <i
                                                id="IconS"
                                                class="fas fa-eye darkMode-icon"
                                                style="position: relative; right: -2px;"
                                            ></i>
                                        </a>
                                        <a
                                            data-toggle="tooltip"
                                            title="Ver deposito"
                                            onclick="showVoucherCheck( '{{ $o->id }}' )"
                                            type="button"
                                            class="mg-10-1"
                                        >
                                            <i id="IconI" class="fas fa-image darkMode-icon"></i>
                                        </a>
                                        @else
                                        <a
                                            data-toggle="tooltip"
                                            title="Mostra informacion"
                                            onclick="ShowOrderModal( '{{ $o->id }}' )"
                                            data-bs-toggle="modal"
                                            data-bs-whatever="@fat"
                                            class="mg-10-1"
                                            style="padding: 7px 5px 7px 5px !important;"
                                        >
                                            <i
                                                id="IconS"
                                                class="fas fa-eye darkMode-icon"
                                                style="position: relative; right: -2px;"
                                            ></i>
                                        </a>
                                        <a
                                            data-toggle="tooltip"
                                            title="Ver deposito"
                                            onclick="showVoucherCheck( '{{ $o->id }}' )"
                                            type="button"
                                            class="mg-10-1"
                                        >
                                            <i id="IconI" class="fas fa-image darkMode-icon"></i>
                                        </a>
                                        @endif
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
<script src="{{ asset('/adminlte/js/pages/dashboard3.js') }}"></script>

@include('admin.orders.create') @include('admin.orders.show') @endsection
