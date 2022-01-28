<div class="card">
    <div class="card-header border-0">
        <h3 class="card-title">Ventas totales</h3>
            <div class="input-group mb-3 d-grid d-md-flex justify-content-md-end">
              <input
                  type="text"
                  class="form-control"
                  id="datepicker"
                  name="datepicker"
                  placeholder="Por favor seleccionar"
              />
            <div class="input-group-append">
                <button onclick="filterForDate()" class="input-group-text">
                    <span class="far fa-calendar-alt"></span>
                </button>
            </div>
        </div>
    </div>
    <div class="card-body table-responsive p-0"  style="padding: 20px !important;">
        <table id="tableResume" class="table table-bordered table-valign-middle tablesDates">
            <thead>
                <tr>
                    <th>{{ __("Paises") }}</th>
                    <th>{{ __("Total Entrega") }}</th>
                    <th>{{ __("Cant. Pedidos") }}</th>
                    <th>{{ __("Total Domicilios") }}</th>
                    <th>{{ __("Cant. Productos") }}</th>
                    <th>{{ __("Total Costo") }}</th>
                    <th>{{ __("Total Utilidad") }}</th>
                </tr>
            </thead>
            <tbody>
                @if(count($countryXOrdes) === 0)
                    <tr>
                        <td>{{ "No se registran ventas hoy" }}</td>
                        <td>{{"$0"}}</td>
                        <td>{{ "0" }}</td>
                        <td>{{"$0"}}</td>
                        <td>{{ "0" }}</td>
                        <td>{{"$0"}}</td>
                        <td>{{"$0"}}</td>
                    </tr>
                @else
                    @for($j=0; $j < count($countryXOrdes); $j++)
                        <tr>
                            <td>{{ $countryXOrdes[$j]['pais'] }}</td>

                            <td>
                                {{"$"}}
                                {{ number_format($countryXOrdes[$j]['subtotal'], 0, ',', '.') }}</td>

                            <td>{{ $countryXOrdes[$j]['sales'] }}</td>
                            <td>
                                {{"$"}}
                                {{ number_format($countryXOrdes[$j]['delivery'], 0, ',', '.') }}</td>

                            <td>{{ $countryXOrdes[$j]['salesProd'] }}</td>
                            <td>
                                {{"$"}}
                                {{ number_format($countryXOrdes[$j]['prodCosto'], 0, ',', '.') }}</td>

                            <td>
                                {{"$"}}
                                {{ number_format($countryXOrdes[$j]['neto'], 0, ',', '.') }}</td>
                        </tr>
                    @endfor
                @endif
            </tbody>
            <tfoot>
                <tr style="font-weight: bold;">
                    <td scope="row" id="totalText">Total</td>
                    <td colspan="2" id="total">
                        {{ "$" }}
                        {{ number_format($subtotal, 0, ',', '.') }}
                    </td>
                    <td id="totalDelivery">
                        {{ "$" }}
                        {{ number_format($delivery, 0, ',', '.') }}
                    </td>
                    <td colspan="2">
                        {{ "$" }}
                        {{ number_format($totalCosto, 0, ',', '.') }}
                    </td>
                    <td id="totalNeto">
                        {{ "$" }}
                        {{ number_format($totalNeto, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
