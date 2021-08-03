@extends('admin.layout') @section('title', __('Create product'))
@section('titleSup', __('Products')) @section('explorer')
<li class="breadcrumb-item">
    <a href="{{ route('products.index') }}">{{ __("Products") }}</a>
</li>
<li class="breadcrumb-item active">
    {{ __("Create product") }}
</li>
@endsection @section('content')

<div class="register-box">
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <b
                ><span
                    class="fas fa-user-plus"
                    style="margin-right: 5px;"
                ></span>
                {{ __("i18n.screen_login.text_nav_login1") }}</b
            >
        </div>
        <div class="card-body">
            <p class="login-box-msg">
                {{ __("Register new product") }}
            </p>

            <form action="" method="POST">
                @csrf
                <div class="input-group mb-3">
                    <input
                        type="number"
                        class="form-control"
                        placeholder="Codigo del producto"
                        id="code"
                        name="code"
                        onkeypress="return valideKey(event);"
                    />
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-barcode"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Nombre del producto"
                        id="name"
                        name="name"
                    />
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-file-signature"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input
                        class="form-control __format_currency__"
                        placeholder="Precio $$"
                        id="price"
                        name="price"
                        onkeypress="return validePrice(event);"
                    />
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-dollar-sign"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input
                        type="number"
                        class="form-control"
                        placeholder="Cantidad"
                        id="quantity"
                        name="quantity"
                        onkeypress="return validequantity(event);"
                    />
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="far fa-chart-bar"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input
                        class="form-control"
                        type="file"
                        id="formFile"
                        class="formFile"
                    />
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-images"></span>
                        </div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <textarea
                        type="text"
                        class="form-control"
                        placeholder="Desripcion breve del producto"
                        id="description"
                        name="description"
                        onkeyup="return limitar(event,this.value,200);"
                        onkeydown="return limitar(event,this.value,200);"
                        style=" min-height: 130px;"
                    ></textarea>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-heading"></span>
                        </div>
                    </div>
                </div>
                <br />
                <div class="row">
                    <!-- /.col -->
                    <div class="d-grid gap-2">
                        <button
                            onclick="registerProduct();"
                            class="btn btn-dark"
                            type="button"
                        >
                            {{ __("Product register") }}
                        </button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>
        </div>
        <!-- /.form-box -->
    </div>
    <!-- /.card -->
</div>
<script
    src="https://code.jquery.com/jquery-3.6.0.js"
    integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous"
></script>
<script src="/adminlte/js/autoNumeric.js" type="text/javascript"></script>
<script src="/adminlte/js/autoNumeric.min.js" type="text/javascript"></script>
<script>
    new AutoNumeric(".__format_currency__", {
        currencySymbol: " $",
        decimalCharacter: ",",
        digitGroupSeparator: ".",
        decimalPlaces: "0"
    });
</script>
<script src="/adminlte/js/products/ValidateCreateProduct.js"></script>
@endsection
