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
                    class="nav-link active darkMode-nav"
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
                    class="nav-link"
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
                    class="nav-link"
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
                            class="nav-link"
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
                            class="fas fa-box-open"
                            style="margin-right: 5px; font-size: 1.5em;"
                        ></i
                        >{{ __("Pedidos Entregados") }}
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
                                    {{ __("Products") }}
                                </th>
                                <th>
                                    {{ __("Domicilio") }}
                                </th>
                                <th>
                                    {{ __("Venta") }}
                                </th>
                                <th>
                                    {{ __("Subtotal") }}
                                </th>
                                <th>
                                    {{ __("Total") }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($orders as $o)
                            <tr>
                                <td class="darkMode-fill">{{ $o->id }}</td>
                                <td class="darkMode-fill">{{ $o->user->name }}
                                    <br />
                                    <p style="opacity: 0.6; font-size: 0.8em;">
                                        Creado
                                        {{ $o->created_at->diffForHumans() }}
                                        <br>
                                        Entregado
                                        {{ $o->updated_at->diffForHumans() }}
                                    </p>
                                </td>
                                <td class="darkMode-fill">
                                    {{ $o->city->state->country->name }} <br />
                                    {{ $o->city->state->name }} <br />
                                    {{ $o->city->name }}
                                </td>
                                <td class="darkMode-fill">{{ $o->client->name }}</td>
                                <td class="darkMode-fill">{{ $o->delivery_date }}</td>
                                <td class="darkMode-fill">
                                    @for($i = 0; $i < count($o->order_items); $i++)
                                        @for($p = 0; $p < count($o->order_items[$i]->product); $p++)
                                            {{ $o->order_items[$i]->quantity }} -
                                            {{ $o->order_items[$i]->product[$p]->name }} <br />
                                        @endfor
                                    @endfor
                                </td>
                                <td class="darkMode-fill">
                                    {{ "$" }}
                                    {{ number_format($o->delivery_price, 0, ',', '.') }}
                                </td>
                                <td class="darkMode-fill">
                                    {{ "$" }}
                                    {{ number_format($o->total, 0, ',', '.') }}
                                </td>
                                <td class="darkMode-fill">
                                    @for($r=0; $r < count($subtotal); $r++)
                                        @if($subtotal[$r]->id == $o->id)
                                            {{ "$" }}
                                            {{ number_format($subtotal[$r]->subtotal, 0, ',', '.') }}
                                        @endif
                                    @endfor
                                </td>
                                        @php
                                        for($i=0; $i < count($o->order_items); $i++){
                                            for($p=0; $p < count($o->order_items[$i]->product); $p++){
                                                $subtotal1 = $o->order_items[$i]->quantity * $o->order_items[$i]->product[$p]->price;
                                                $neto = ($o->total - $o->delivery_price) - $subtotal1;
                                            }
                                        }
                                        @endphp
                                        <td class="darkMode-fill">
                                            {{ "$" }}
                                            {{ number_format($neto, 0, ',', '.') }}
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

@include('admin.orders.create') @endsection
