@extends('admin.layout') @section('title', __('Editar Pedido'))
@section('titleSup', __('Pedidos')) @section('explorer')
<li class="breadcrumb-item">
    <a class="darkMode-text" href="{{ route('orders.index') }}">{{ __("Orders") }}</a>
</li>
<li class="breadcrumb-item active">
    {{ __("Editar Pedido") }}
</li>
@endsection @section('content')
<form class="row g-3" method="PUT" enctype="multipart/form-data" style="display: flex; justify-content: center">
    <div class="col-auto" style="width: 500px">
            <div class="card card-outline card-primary">
                <div class="card-header darkMode-bbg text-center" style="height: 60px;">
                    <b
                        ><span
                            class="fas fa-clipboard-list"
                            style="margin-right: 5px;"
                        ></span>
                        {{ __("Pedido") }} - {{ $order->id }}</b> <br>
                        <p>{{ __("Datos del cliente") }}</p>
                </div>
                <div class="card-body darkMode-bbg">
                        @method('patch') @csrf
                        <div class="input-group mb-3">
                            <input
                                type="number"
                                class="form-control"
                                id="identification"
                                name="identification"
                                value="{{ $order->client->identification }}"
                            />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="far fa-id-card"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Nombre del cliente"
                                id="name"
                                name="name"
                                value="{{ $order->client->name }}"
                            />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                        @for($i = 0; $i < count($address);$i++)
                            @if($address[$i]->id == $order->id)
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Direccion"
                                id="address"
                                name="address"
                                value="{{ $address[$i]->address }}"
                            />
                            @endif
                        @endfor
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-home"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                        @for($i = 0; $i < count($address);$i++)
                            @if($address[$i]->id == $order->id)
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Barrio"
                                id="neighborhood"
                                name="neighborhood"
                                value="{{ $address[$i]->neighborhood }}"
                            />
                            @endif
                        @endfor
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-map-marker-alt"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                        <input type="text" class="form-control" style="max-width: 55px;" value="+57" name="phonecode" id="phonecode" disabled>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Telefono"
                                id="phone"
                                name="phone"
                                value="{{ $order->client->phone }}"
                            />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-mobile-alt"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input
                                type="text"
                                class="form-control"
                                placeholder="WhatsApp"
                                id="whatsapp"
                                name="whatsapp"
                                value="{{ $order->client->whatsapp }}"
                            />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fab fa-whatsapp"></span>
                                </div>
                            </div>
                        </div>
                </div>
                <!-- /.form-box -->
            </div>
            <!-- /.card -->
            <div class="card card-outline card-primary">
                <div class="card-header text-center darkMode-bbg" style="height: 60px;">
                    <button type="button" class="btn btn-outline-success bg-success" id="addProduct"
                     style="position: absolute; display: block; left: 425px;">
                        <span class="fas fa-plus" style="color: #fff;"></span>
                    </button>
                    <b
                        ><span
                            class="fas fa-clipboard-list"
                            style="margin-right: 5px;"
                        ></span>
                        {{ __("Pedido") }} - {{ $order->id }}</b> <br>
                        <p>{{ __("Lista de items") }}</p>


                </div>
                <div class="card-body darkMode-bbg">
                    <div class="form-group fieldGroupCopy">
                    @for($i = 0; $i < count($order->order_items);$i++)
                        @for($p = 0; $p < count($products);$p++)
                            @if($order->order_items[$i]->product_id == $products[$p]->id)
                        <div class="input-group mb-3 contentAdd copy-{{ $i }}">
                            <input type="number" class="form-control copy_quantity" style="max-width: 60px;" value="{{ $order->order_items[$i]->quantity }}" name="quantity">
                                <select class="form-control col-md-11 custom-select copy" name="product" {{ old('product') }}>
                                    <option value="{{ $products[$p]->id }}" selected>{{$products[$p]->name}}</option>
                                @for($r = 0; $r < count($products); $r++)
                                    <option value="{{ $products[$r]->id }}">{{$products[$r]->name}}</option>
                                @endfor
                                </select>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary bg-danger trash-only" value="copy-{{ $i }}" onclick="trashProduct(this.value, {{ $products[$p]->id }}, {{ $order->id }})">
                                    <span class="fas fa-trash-alt" style="color: #fff;"></span>
                                </button>
                            </div>
                        </div>
                            @endif
                        @endfor
                    @endfor
                        <div class="input-group mb-3" id="ShowMoreProduct" style="display: none;">
                            <input type="number" class="form-control" style="max-width: 60px;" value="1" name="quantity_copy">
                                <select class="form-control col-md-11 custom-select product_copy" name="product_copy"
                                {{ old('product_copy') }}>
                                @for($r = 0; $r < count($products); $r++)
                                    <option value="{{ $products[$r]->id }}">{{$products[$r]->name}}</option>
                                @endfor
                                </select>
                            <div class="input-group-append">
                                <button type="button" class="btn btn-outline-secondary bg-danger" onclick="trashProduct(this.value, {{ $order->id }})">
                                    <span class="fas fa-trash-alt" style="color: #fff;"></span>
                                </button>
                            </div>
                        </div>
                      </div>
                        <div class="input-group mb-3">
                            <span class="input-group-text">$</span>
                                <input value="{{ $order->total }}" class="form-control __format_currency__" name="total" id="total" placeholder="Valor de venta">
                            <span class="input-group-text">.00</span>
                        </div>
            </div>
        </div>
    </div>

    <div class="col-auto" style="width: 500px">
            <div class="card card-outline card-primary">
                <div class="card-header text-center darkMode-bbg" style="height: 60px;">
                    <b
                        ><span
                            class="fas fa-clipboard-list"
                            style="margin-right: 5px;"
                        ></span>
                        {{ __("Pedido") }} - {{ $order->id }}</b> <br>
                        <p>{{ __("Datos de envio") }}</p>
                </div>
                <div class="card-body darkMode-bbg">
                        <div class="input-group mb-3">
                            <select id="country_id" name="country_id" class="form-control"
                            onchange="changeCountryType(this.value)">
                                <option value="0" disabled
                                    >---Seleccione pais de origen---</option
                                >
                                @foreach( $country as $c )
                                    @if($order->city->state->country->id == $c['id'])
                                        <option value="{{ $c['id'] }}" selected>{{ $c['name'] }}</option>
                                            @else
                                        <option value="{{ $c['id'] }}">{{ $c['name'] }}</option>
                                    @endif
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-globe-americas"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <select
                                id="state_id"
                                name="state_id"
                                class="form-control"
                                onchange="changeStateType(this.value)"
                                {{ old('country_id') ? '' : 'disabled' }}
                            >
                            <option selected>---Seleccione estado---</option>
                            </select>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-flag-usa"></span>
                                </div>
                            </div>
                        </div>
                <div class="input-group mb-3">
                    <select id="city_id" name="city_id" class="form-control" onchange="changeCity(this.value)"
                    {{ old('state_id') ? '' : 'disabled' }}>
                    </select>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-city"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card card-outline card-primary">
            <div class="card-header text-center darkMode-bbg" style="height: 60px;">
                <b
                    ><span
                        class="fas fa-clipboard-list"
                        style="margin-right: 5px;"
                    ></span>
                    {{ __("Pedido") }} - {{ $order->id }}</b> <br>
                    <p>{{ __("Tipo de pago") }}</p>
            </div>
                <div class="card-body darkMode-bbg">
                    <div class="input-group mb-3">
                        <select
                        id="payment_type_id" name="payment_type_id" class="form-control">
                        @foreach( $payment_type as $pt )
                            @if($order->payment_type_id == $pt->id)
                                <option value="{{ $pt->id }}" selected>{{ $pt->name }}</option>
                            @else
                                <option value="{{ $pt->id }}">{{ $pt->name }}</option>
                            @endif
                        @endforeach
                        </select>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-money-check-alt"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input class="form-control form-control-sm" id="LoadVoucher" name="LoadVoucher" type="file" hidden>
                </div>
            </div>
        </div>
        <div class="card card-outline card-primary">
            <div class="card-header text-center darkMode-bbg" style="height: 60px;">
                <b
                    ><span
                        class="fas fa-clipboard-list"
                        style="margin-right: 5px;"
                    ></span>
                    {{ __("Pedido") }} - {{ $order->id }}</b> <br>
                    <p>{{ __("Fecha y hora") }}</p>
            </div>
                <div class="card-body darkMode-bbg">
                    <div class="input-group mb-3 delivery_date_info">
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Fecha de entrega"
                            id="delivery_date_info"
                            name="delivery_date_info"

                        />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="far fa-calendar-alt"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <button button type="button" id="renew" class="btn btn-dark">Reagendar pedido</button>
                        <button button type="button" id="close" class="btn btn-danger" style="display: none"><span class="fas fa-times"></span></button>
                    </div>
                    <div class="input-group mb-3 delivery_date" style="display: none">
                        <input
                            type="datetime-local"
                            class="form-control"
                            placeholder="Fecha de entrega"
                            id="delivery_date"
                            name="delivery_date"
                        />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="far fa-calendar-alt"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3 reason" style="display: none">
                        <textarea
                            type="text"
                            class="form-control"
                            placeholder="Motivos..."
                            onkeyup="return limitar(event,this.value,200);"
                            onkeydown="return limitar(event,this.value,200);"
                            id="reason"
                            name="reason"></textarea>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="far fa-sticky-note"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <textarea
                            type="text"
                            class="form-control"
                            placeholder="Nota..."
                            id="notes"
                            name="notes"
                        >{{ $order->notes }}</textarea>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="far fa-sticky-note"></span>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
</form>
    <div class="row" style="display: flex; justify-content: center; padding-bottom: 20px;">
        <div class="d-grid gap-2" style="width: 1000px">
        @foreach ($address as $a)
            @if($a->id == $order->id)
               <button
                    onclick="EditOrder({{ $order->id }}, {{ $order->client->id }}, {{ $a->id }}, {{ $order->user_id }}, '{{$order->delivery_date}}');"
                    class="btn btn-dark"
                    type="button">
                    {{ __("Editar pedido") }}
                </button>
            @endif
        @endforeach
        </div>
    </div>
<script
    src="https://code.jquery.com/jquery-3.6.0.js"
    integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
    crossorigin="anonymous"
></script>
<script src="/adminlte/js/autoNumeric.js" type="text/javascript"></script>
<script src="/adminlte/js/autoNumeric.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        $("#renew").click(function(e) {
        e.preventDefault();
            let element = document.querySelector(".delivery_date");
                element.style.setProperty("display", "flex");
            let element3 = document.querySelector("#close");
                element3.style.setProperty("display", "flex");
            let element2 = document.querySelector(".reason");
                element2.style.setProperty("display", "flex");
            let element4 = document.querySelector("#renew");
                element4.style.setProperty("display", "none");
            let element5 = document.querySelector(".delivery_date_info");
                element5.style.setProperty("display", "none");
        });

        $("#close").click(function(e) {
        e.preventDefault();
            let element = document.querySelector(".delivery_date");
                element.style.setProperty("display", "none");
            let element3 = document.querySelector("#close");
                element3.style.setProperty("display", "none");
            let element2 = document.querySelector(".reason");
                element2.style.setProperty("display", "none");
            let element4 = document.querySelector("#renew");
                element4.style.setProperty("display", "flex");
            let element5 = document.querySelector(".delivery_date_info");
                element5.style.setProperty("display", "flex");
            $("#delivery_date").val("");
            $("#reason").val("");
        });
        let fecha = new Date('{{ $order->delivery_date }}');
        let options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        $("#delivery_date_info").val(fecha.toLocaleString('es', options));

        payment_type = "{{ $order->payment_type_id }}"
        if (payment_type == 2) {
            $("#LoadVoucher").prop("hidden", false);
        } else {
            if (payment_type == 1) {
                $("#LoadVoucher").prop("hidden", true);
            }
        }

        $("select[name='payment_type_id']").change(function() {
            if ($("select[name='payment_type_id']").val() == 1) {
                $("#LoadVoucher").prop("hidden", true);
            }

            if ($("select[name='payment_type_id']").val() == 2) {
                $("#LoadVoucher").prop("hidden", false);
            }
        });

    });
    new AutoNumeric(".__format_currency__", {
        currencySymbol: " $",
        decimalCharacter: ",",
        digitGroupSeparator: ".",
        decimalPlaces: "0"
    });

</script>
<script>
    var country_code_value = '{{ old("country_id") }}' || "{{ $order->city->state->country->id }}";
            if (country_code_value && country_code_value != "") {
                changeCountryType(country_code_value);
            }

        var state_code_value = '{{ old("state_id") }}' || "{{ $order->city->state->id }}";
            if (state_code_value && state_code_value != "") {
                changeStateType(state_code_value);
            }

            function changeCountryType(country_code) {
                var state_id = "{{ $order->city->state->id }}";

                $.ajax({
                    type: "GET",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    url: "/optionCountry/state/" + country_code,
                    data: null,
                    success: function(r) {
                        if (!r) {
                            r = JSON.parse(r);
                        }
                        if (r) {
                            $("#state_id").prop("disabled", false);
                            $("#state_id option").remove();
                            $("#state_id").append('<option value="0" selected>---Seleccione estado---</option>');
                            for (var i = 0; i < r.d.states.length; i++) {
                                if (state_id == r.d.states[i].id ) {
                                    $("#state_id").append(
                                        '<option value="' + r.d.states[i].id + '" selected>' + r.d.states[i].name + "</option>"
                                    );
                                } else {
                                    $("#state_id").append(
                                        '<option value="' +
                                            r.d.states[i].id +
                                            '">' +
                                            r.d.states[i].name +
                                            "</option>"
                                    );
                                }
                            }
                        }
                    },
                    error: function(textStatus, errorThrown) {
                        alert("error");
                    }
                });
            }

            function changeStateType(state_code) {
                 var city_id = "{{ $order->city_id }}";

                 $.ajax({
                    type: "GET",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    url: "/optionState/city/" + state_code,
                    data: null,
                    success: function(r) {
                        if (!r) {
                            r = JSON.parse(r);
                        }
                        if (r) {
                            $("#city_id").prop("disabled", false);
                            $("#city_id").append('<option value="0" selected disabled>Municipio</option>');
                            $("#city_id option").remove();
                            for (var i = 0; i < r.d.cities.length; i++) {
                                if (city_id == r.d.cities[i].id) {
                                    $("#city_id").append(
                                        '<option value="' + r.d.cities[i].id + '" selected>' + r.d.cities[i].name + "</option>"
                                    );
                                } else {
                                    $("#city_id").append(
                                        '<option value="' +
                                            r.d.cities[i].id +
                                            '">' +
                                            r.d.cities[i].name +
                                            "</option>"
                                    );
                                }
                            }
                        }
                    },
                    error: function(textStatus, errorThrown) {
                        alert("error");
                    }
                });
            }
            function changeCity(city_id) {
                localStorage.setItem("city_id", city_id);
            }
    </script>
    <script src="/adminlte/js/orders/EditOrder.js"></script>
@endsection
