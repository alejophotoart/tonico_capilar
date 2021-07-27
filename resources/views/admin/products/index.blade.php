@extends('admin.layout') @section('title', __('Products')) @section('titleSup',
__('Products')) @section('explorer')
<li class="breadcrumb-item active">
    {{ __("Products") }}
</li>
@endsection @section('content')
<div class="content" style="text-align: center;">
    <div class="card">
        <div class="card-header">
            <h1 class="card-title">{{ __("Prodcuts list") }}</h1>
            @if(auth()->user()->role_id == 1 || auth()->user()->role_id == 2)
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="{{ route('products.create') }}"
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
                    @foreach ($products as $product)
                    <tr>
                        <td id="content-id">
                            {{ $product->id }}
                        </td>
                        <td>
                            @if($product->img !== null)
                            <div class="d-flex justify-content-center">
                                <div class="image-product">
                                    <img
                                        src="{{$product->link}}{{$product->img}}"
                                        alt="{{$product->name}}"
                                        class="img-circle elevation-2"
                                        id="imgProduct"
                                    />
                                </div>
                            </div>
                            @else
                            <div class="d-flex justify-content-center">
                                <div class="image-product">
                                    <img
                                        src="/adminlte/img/products/default.png"
                                        alt="{{$product->name}}"
                                        class="img-circle elevation-2"
                                        id="imgProduct"
                                    />
                                </div>
                            </div>
                            @endif
                        </td>
                        <td id="content-name">
                            {{ $product->name }}
                        </td>
                        <td id="content-price">
                            {{ "$" }}
                            {{ number_format($product->price, 0, ',', '.') }}
                        </td>
                        <td id="content-quantity">
                            {{ $product->quantity }}
                        </td>
                        <td id="actions">
                            @if(auth()->user()->role_id == 1 ||
                            auth()->user()->role_id == 2)
                            <a
                                href="{{ route('products.edit', $product) }}"
                                class="mg-10"
                            >
                                <i id="IconE" class="fas fa-pencil-alt"></i>
                            </a>
                            <a
                                class="mg-10"
                                onclick="DeleteProduct('{{$product->id}}', '{{$product->name}}')"
                            >
                                <i id="IconD" class="fas fa-trash-alt"></i>
                            </a>
                            <a
                                onclick="ShowInfoProduct('{{$product->id}}')"
                                data-bs-toggle="modal"
                                data-bs-whatever="@fat"
                                class="mg-10-1"
                            >
                                <i id="IconS" class="fas fa-eye"></i>
                            </a>
                            @else
                            <a
                                onclick="ShowInfoProduct('{{$product->id}}')"
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
<script src="/adminlte/js/products/ShowProducts.js"></script>
<script src="/adminlte/js/products/DeleteProduct.js"></script>
@include('admin.products.show') @endsection
