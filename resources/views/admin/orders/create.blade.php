<div
    class="modal fade"
    id="CreateOrderModal"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Crear pedido</h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <div class="card text-white bg-dark mb-3" id="card-order" style="max-width: 400px;
                margin: 0 auto; float: none; margin-bottom: 20px !important;">
                    <div class="card-header" id="card-header-order"
                    >{{__('Datos del vendedor :')}}</div>
                    <div class="card-body" id="card-body-order" style="padding: 8px;">
                        <div class="input-group mb-3">
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Nombre del vendedor"
                                id="name_user"
                                name="name_user"
                            />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Tipo de usuario"
                                id="role_id_user"
                                name="role_id_user"
                            />
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user-shield"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form class="row g-3">
                <div class="col-md-4">
                    <div class="card text-white bg-dark mb-3" id="card-order">
                        <div class="card-header" id="card-header-order"
                        >{{__('Datos del cliente :')}}</div>
                        <div class="card-body" id="card-body-order">
                            <div class="input-group mb-3">

                                <button id="client_validate" type="button" class="btn btn-ligth" onclick="searchClient()">
                                    <span class="fas fa-search"></span>
                                </button>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="identificacion"
                                    id="identification"
                                    name="identification"
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
                                    placeholder="Nombre completo"
                                    id="name"
                                    name="name"
                                />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Direccion completa"
                                    id="address"
                                    name="address"
                                />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-home"></span>
                                    </div>
                                </div>
                            </div>
                                <div class="input-group mb-3">
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Barrio"
                                        id="neighborhood"
                                        name="neighborhood"
                                    />
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-map-marker-alt"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" style="max-width: 55px;" value="+57" name="phonecode" id="phonecode" disabled>
                                    <input
                                        type="number"
                                        class="form-control"
                                        placeholder="Telefono"
                                        id="phone"
                                        name="phone"
                                        onkeypress="return validePhone(event);"
                                    />
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-mobile-alt"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <input
                                        type="number"
                                        class="form-control"
                                        placeholder="Whatsapp"
                                        id="whatsapp"
                                        name="whatsapp"
                                        onkeypress="return validePhone(event);"
                                    />
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fab fa-whatsapp"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card text-white bg-dark mb-3" id="card-order">
                            <div class="card-header" id="card-header-order"
                            >Datos de envio:</div>
                            <div class="card-body" id="card-body-order">
                        <div class="input-group mb-3">
                            <select id="country_id" name="country_id" class="form-control"
                            onchange="changeCountryType(this.value)">
                                <option selected disabled value="0"
                                    >Seleccione pais</option
                                >
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
                            <option selected disabled>Seleccione departamento</option>
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
                                <option selected disabled>Seleccione ciudad</option>
                            </select>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-city"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3" id="card-order">
                    <div class="card-header" id="card-header-order"
                    >Tipo de pago:</div>
                        <div class="card-body" id="card-body-order" >
                            <div class="input-group mb-3">
                                <select
                                id="payment_type_id"
                                name="payment_type_id"
                                class="form-control"
                                >
                                </select>
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-money-check-alt"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input class="form-control form-control-sm" id="formFileSm" name="formFileSm" type="file" hidden>
                            </div>
                        </div>
                    </div>
                </div>
            <div class="col-md-4">
                <div class="card mb-3" id="card-order">
                    <div class="card-header" id="card-header-order"
                    >Fecha y hora:</div>
                    <div class="card-body" id="card-body-order" >
                        <div class="input-group mb-3">
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
                        <div class="input-group mb-3">
                            <textarea
                                type="text"
                                class="form-control"
                                placeholder="Nota..."
                                id="notes"
                                name="notes"
                            ></textarea>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="far fa-sticky-note"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card mb-3" id="card-order">
                    <div class="card-header" id="card-header-order"
                    >Pedido:</div>
                    <div class="card-body" id="card-body-order" >
                        <div class="form-group fieldGroupCopy">
                            <div class="input-group mb-3" id="contentAdd">
                                <input type="number" class="form-control copy_quantity" style="max-width: 60px;" value="1" name="quantity" id="quantity">
                                    <select class="form-control col-md-11 custom-select copy" name="product" id="product"
                                        {{ old('product') }}>

                                    </select>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-success bg-success" id="addProduct">
                                        <span class="fas fa-plus" style="color: #fff;"></span>
                                    </button>
                                </div>
                            </div>
                            <div class="input-group mb-3" id="ShowMoreProduct" style="display: none;">
                                <input type="number" class="form-control" style="max-width: 60px;" value="1" name="quantity_copy">
                                    <select class="form-control col-md-11 custom-select product_copy" name="product_copy"
                                    {{ old('product_copy') }}>

                                    </select>
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary bg-danger" onclick="trashProduct(this.value)">
                                        <span class="fas fa-trash-alt" style="color: #fff;"></span>
                                    </button>
                                </div>
                            </div>
                          </div>
                            <div class="input-group mb-3">
                                <span class="input-group-text">$</span>
                                    <input type="text" class="form-control __format_currency1__" name="total" id="total" placeholder="Valor de venta">
                                <span class="input-group-text">.00</span>
                            </div>
                            <div class="input-group mb-3" style="display: none;">
                                <span class="input-group-text">$</span>
                                    <input type="text" class="form-control __format_currency__" id="delivery_price" name="delivery_price" placeholder="Valor de domicilio">
                                <span class="input-group-text">.00</span>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            </div>
            <div class="modal-footer">
                <button
                    type="button"
                    class="btn btn-danger"
                    data-bs-dismiss="modal"
                >
                    {{__('Close')}}
                </button>
                <button type="button" class="btn btn-dark"
                {{-- onclick="message()" > --}}
                onclick="CreateOrder('{{ auth()->user()->id }}')">
                    {{__('Generar pedido')}}
                </button>
            </div>
        </div>
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
    new AutoNumeric(".__format_currency__",{
        currencySymbol: " $",
        decimalCharacter: ",",
        digitGroupSeparator: ".",
        decimalPlaces: "0"
    });

    new AutoNumeric(".__format_currency1__",{
        currencySymbol: " $",
        decimalCharacter: ",",
        digitGroupSeparator: ".",
        decimalPlaces: "0"
    });
</script>

