<div
    class="modal fade"
    id="ModalShowInfo"
    tabindex="-1"
    aria-labelledby="exampleModalLabel"
    aria-hidden="true"
>
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    Detalle del pedido #
                </h5>
                <h5 class="modal-title" id="ordersNum"></h5>
                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <form class="row g-3">
                    <div class="col-md-4">
                        <div
                            class="card text-white bg-dark mb-3"
                            id="card-order"
                        >
                            <div class="card-header" id="card-header-order">
                                {{ __("Datos del cliente :") }}
                            </div>
                            <div
                                class="card-body"
                                id="card-body-order"
                                style="background-color: #fff;"
                            >
                                <div class="input-group mb-3">
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="identificacion"
                                        id="identification_client"
                                        name="identification_client"
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
                                        id="name_client"
                                        name="name_client"
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
                                        placeholder="Direccion completo"
                                        id="address_client"
                                        name="address_client"
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
                                        id="neighborhood_client"
                                        name="neighborhood_client"
                                    />
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span
                                                class="fas fa-map-marker-alt"
                                            ></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <input
                                        type="text"
                                        class="form-control"
                                        style="max-width: 55px;"
                                        value="+57"
                                        name="phonecode"
                                        id="phonecode_client"
                                        disabled
                                    />
                                    <input
                                        type="number"
                                        class="form-control"
                                        placeholder="Telefono"
                                        id="phone_client"
                                        name="phone_client"
                                    />
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span
                                                class="fas fa-mobile-alt"
                                            ></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <input
                                        type="number"
                                        class="form-control"
                                        placeholder="Whatsapp"
                                        id="whatsapp_client"
                                        name="whatsapp_client"
                                    />
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span
                                                class="fab fa-whatsapp"
                                            ></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div
                            class="card text-white bg-dark mb-3"
                            id="card-order"
                        >
                            <div class="card-header" id="card-header-order">
                                Datos de envio:
                            </div>
                            <div
                                class="card-body"
                                id="card-body-order"
                                style="background-color: #fff;"
                            >
                                <div class="input-group mb-3">
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Pais"
                                        id="country_client"
                                        name="country_client"
                                    />
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span
                                                class="fas fa-globe-americas"
                                            ></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Departamento"
                                        id="state_client"
                                        name="state_client"
                                    />
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span
                                                class="fas fa-flag-usa"
                                            ></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Ciudad"
                                        id="city_client"
                                        name="city_client"
                                    />
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-city"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Fecha de entrega"
                                        id="delivery_date_client"
                                        name="delivery_date_client"
                                    />
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span
                                                class="far fa-calendar-alt"
                                            ></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <textarea
                                        type="text"
                                        class="form-control"
                                        placeholder="Nota..."
                                        id="notes_client"
                                        name="notes_client"
                                    ></textarea>
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span
                                                class="far fa-sticky-note"
                                            ></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card mb-3" id="card-order">
                            <div class="card-header" id="card-header-order">
                                Tipo de pago:
                            </div>
                            <div
                                class="card-body"
                                id="card-body-order"
                                style="background-color: #fff;"
                            >
                                <div class="input-group mb-3">
                                    <input
                                        type="text"
                                        class="form-control"
                                        placeholder="Tipo de pago"
                                        id="payment_type_id_client"
                                        name="payment_type_id_client"
                                    />
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span
                                                class="fas fa-money-check-alt"
                                            ></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <button
                                        id="buttonVoucher"
                                        type="button"
                                        class="btn btn-secondary btn-sm"
                                        hidden
                                    >
                                        <i class="fas fa-camera"> </i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card mb-3" id="card-order">
                            <div class="card-header" id="card-header-order">
                                Pedido:
                            </div>
                            <div
                                class="card-body"
                                id="card-body-order"
                                style="background-color: #fff;"
                            >
                                <div class="form-group fieldGroup">
                                    <div
                                        class="input-group mb-3"
                                        id="contentProductShow"
                                        hidden
                                    >
                                        <input
                                            type="text"
                                            class="form-control quantity_client"
                                            style="max-width: 55px;"
                                            name="quantity_client"
                                        />
                                        <input
                                            class="form-control col-md-11 product_client"
                                            name="product_client"
                                        />

                                        <div class="input-group-append">
                                            <div class="input-group-text" id>
                                                <span
                                                    class="fas fa-clipboard-list"
                                                ></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">$</span>
                                    <input
                                        type="text"
                                        class="form-control __format_currency1__"
                                        name="total_price"
                                        id="total_price"
                                    />
                                    <span class="input-group-text">.00</span>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">$</span>
                                    <input
                                        type="text"
                                        class="form-control __format_currency__"
                                        id="delivery_price_client"
                                        name="delivery_price_client"
                                    />
                                    <span class="input-group-text">.00</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <h5>Vendedor:</h5>
                <h5 id="salesman"></h5>
            </div>
        </div>
    </div>
</div>
