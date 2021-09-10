<div class="card">
    <div class="card-header border-0">
        <h3 class="card-title">Ventas totales</h3>
            <div class="input-group mb-3 d-grid d-md-flex justify-content-md-end">
              <input
                  type="text"
                  class="form-control"
                  id="datepicker"
                  name="datepicker"
                  style="max-width: 150px;"
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
                    <th>{{ __("Ventas") }}</th>
                    <th>{{ __("Cant.") }}</th>
                    <th>{{ __("Domicilios") }}</th>
                    <th>{{ __("Total") }}</th>
                </tr>
            </thead>
            <tbody>
                @if(count($countryXOrdes) === 0)
                    <tr>
                        <td>{{ "No se registran ventas hoy" }}</td>
                        <td>{{"$0"}}</td>
                        <td>{{ "0" }}</td>
                        <td>{{"$0"}}</td>
                        <td>{{"$0"}}</td>
                    </tr>
                @else
                    @for($i=0; $i < count($countryXOrdes); $i++)
                        <tr>
                            <td>{{ $countryXOrdes[$i]['pais'] }}</td>

                            <td>
                                {{"$"}}
                                {{ number_format($countryXOrdes[$i]['subtotal'], 0, ',', '.') }}</td>

                            <td>{{ $countryXOrdes[$i]['sales'] }}</td>

                            <td>
                                {{"$"}}
                                {{ number_format($countryXOrdes[$i]['delivery'], 0, ',', '.') }}</td>

                            <td>
                                {{"$"}}
                                {{ number_format($countryXOrdes[$i]['neto'], 0, ',', '.') }}</td>
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
                    <td id="totalNeto">
                        {{ "$" }}
                        {{ number_format($neto, 0, ',', '.') }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
