<div class="card">
    <div class="card-header border-0" style="padding: 10px 20px 0px !important;">
        <h3 class="card-title">Mensajes de WhatsApp</h3>
    </div>
    <div class="card-body table-responsive p-0"  style="padding: 20px !important;">
        <table id="tableResume" class="table table-bordered table-valign-middle tablesDates">
            <thead>
                <tr>
                    <th  colspan="6">{{ __("Telefonos") }}</th>
                </tr>
                <tr>
                    <th>{{ __("Fecha") }}</th>
                    <th>{{ __("M1") }}</th>
                    <th>{{ __("M2") }}</th>
                    <th>{{ __("M3") }}</th>
                    <th>{{ __("M4") }}</th>
                    <th>{{ __("Total") }}</th>
                </tr>
            </thead>
            <tbody>
                @if(count($clave) === 0)
                    <tr>
                        <td>{{ date('D, d-M-Y') }} <br> {{ date('H:i:s A') }}</td>
                        <td>{{ "0" }}</td>
                        <td>{{ "0" }}</td>
                        <td>{{ "0" }}</td>
                        <td>{{ "0" }}</td>
                        <td>{{ $totalChats }}</td>
                    </tr>
                @else
                    <tr>
                        <td>{{ date('D, d-M-Y') }} <br> {{ date('H:i:s A') }}</td>
                        <td>{{ count($clave) }}</td>
                        <td>Not Available</td>
                        <td>Not Available</td>
                        <td>Not Available</td>
                        <td>{{ $totalChats }}</td>
                    </tr>

                @endif
            </tbody>
            <tfoot>
                <tr style="font-weight: bold;">
                    <td scope="row" name="totalText">Total</td>
                    <td name="total">{{ $totalChats }}</td>
                    <td name="totalDelivery">{{ "0" }}</td>
                    <td name="totalNeto">{{ "0" }}</td>
                    <td name="totalDelivery">{{ "0" }}</td>
                    <td name="totalNeto">{{ $totalChats }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
