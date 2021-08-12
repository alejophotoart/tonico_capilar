@extends('admin.layout') @section('title', __('Products')) @section('titleSup',
__('Products')) @section('explorer')
<li class="breadcrumb-item active">
    {{ __("Products") }}
</li>
@endsection @section('content')
<div class="content" style="text-align: center;">
    <div class="card">
        <div class="card-header darkMode-bbg">
            <h1 class="card-title">{{ __("Prodcuts list") }}</h1>
            @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
            <div class="float-end">
                <a href="{{ route('products.create') }}"
                    ><button class="btn btn-dark" type="button">
                        <i class="fas fa-plus"></i></button
                ></a>
            </div>
            @endif
        </div>
        <div class="card-body darkMode-bbg">
            <table
                class="table table-responsive-sm"
                style="width:100%"
                id="tableProducts"
            >
                <thead>
                    <tr>
                        <th>
                            {{ __("ID") }}
                        </th>
                        <th>
                            {{ __("Image") }}
                        </th>
                        <th>
                            {{ __("Name") }}
                        </th>
                        <th>
                            {{ __("Price") }}
                        </th>
                        <th>
                            {{ __("Quantity") }}
                        </th>
                        <th>
                            {{__('Bodegas')}}
                        </th>
                        @if(auth()->user()->role_id == 1 ||
                        auth()->user()->role_id == 2 || auth()->user()->role_id
                        == 3)
                        <th>
                            {{ __("Actions") }}
                        </th>

                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $p)
                    <tr>
                        <td class="darkMode-fill" id="content-id">
                            {{ $p->id }}
                        </td>
                        <td class="darkMode-fill">
                            @if($p->img !== null)
                            <div class="d-flex justify-content-center">
                                <div class="image-product darkMode-circle">
                                    <img
                                        src="{{$p->link}}{{$p->img}}"
                                        alt="{{$p->name}}"
                                        class="img-circle elevation-2"
                                        id="imgProduct"
                                    />
                                </div>
                            </div>
                            @else
                            <div class="d-flex justify-content-center">
                                <div class="image-product darkMode-circle">
                                    <img
                                        src="/adminlte/img/products/default.png"
                                        alt="{{$p->name}}"
                                        class="img-circle elevation-2"
                                        id="imgProduct"
                                    />
                                </div>
                            </div>
                            @endif
                        </td>
                        <td class="darkMode-fill" id="content-name">
                            {{ $p->name }}
                        </td>
                        <td class="darkMode-fill" id="content-price">
                            {{ "$" }}
                            {{ number_format($p->price, 0, ',', '.') }}
                        </td>
                        <td class="darkMode-fill" id="content-quantity">
                            {{ $p->quantity }}
                        </td>
                        <td class="darkMode-fill">
                            @foreach ($product_warehouses as $pw)
                                @foreach ($pw->warehouses as $pww)
                                    @if ($p->id == $pw->product_id)
                                        {{$pww->name}} <br>
                                    @endif
                                @endforeach
                            @endforeach
                        </td>
                        <td class="darkMode-fill" id="actions">
                            @if(auth()->user()->role_id == 1 ||
                            auth()->user()->role_id == 2)
                            <a
                                href="{{ route('products.edit', $p) }}"
                                class="mg-10"
                            >
                                <i id="IconE" class="fas fa-pencil-alt darkMode-icon"></i>
                            </a>
                            <a
                                class="mg-10"
                                onclick="DeleteProduct('{{$p->id}}', '{{$p->name}}')"
                            >
                                <i id="IconD" class="fas fa-trash-alt darkMode-icon"></i>
                            </a>
                            <a
                                onclick="ShowInfoProduct('{{$p->id}}')"
                                data-bs-toggle="modal"
                                data-bs-whatever="@fat"
                                class="mg-10-1"
                            >
                                <i id="IconS" class="fas fa-eye darkMode-icon"></i>
                            </a>
                            @else
                            <a
                                onclick="ShowInfoProduct('{{$p->id}}')"
                                data-bs-toggle="modal"
                                data-bs-whatever="@fat"
                                class="mg-10-1"
                            >
                                <i id="IconS" class="fas fa-eye darkMode-icon"></i>
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
<script src="/adminlte/js/products/ShowProducts.js"></script>
<script src="/adminlte/js/products/DeleteProduct.js"></script>
@include('admin.products.show') @endsection
