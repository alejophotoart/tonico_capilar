<div class="card">
    <div class="card-header border-0">
        <h3 class="card-title">{{ __("Products") }}</h3>
    </div>
    <div class="card-body table-responsive p-0">
        <table class="table table-striped table-valign-middle">
            <thead>
                <tr>
                    <th>{{ __("Producto") }}</th>
                    <th>{{ __("Price") }}</th>
                    <th>{{ __("% de venta") }}</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < count($products); $i++)
                <tr id="insertTD-{{ $i }}">
                    <td>
                        @if($products[$i]->img !== null)
                        <img
                            src="{{$products[$i]->link}}{{$products[$i]->img}}"
                            class="img-circle img-size-32 mr-2"
                        />
                        {{$products[$i]->name}}
                        @else
                        <img
                            src="/adminlte/img/products/default.png"
                            class="img-circle img-size-32 mr-2"
                        />
                        {{$products[$i]->name}}
                        @endif
                    </td>
                    <td>
                        {{ "$" }}
                        {{ number_format($products[$i]->price, 0, ',', '.') }}
                    </td>
                </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>
