<div class="table-responsive">
    <table class="table table-bordered table-striped mt-1">
        <thead class="text-white bg-dark">
            <tr>
                <th class="table-th text-white text-center">FOLIO</th>
                <th class="table-th text-white text-center">TOTAL</th>
                <th class="table-th text-white text-center">ITEMS</th>
                <th class="table-th text-white text-center">ESTADO</th>
                <th class="table-th text-white text-center">USUARIO</th>
                <th class="table-th text-white text-center">FECHA</th>
                <th class="table-th text-white text-center" width="50px"></th>
            </tr>
        </thead>
        <tbody>
            @if (!sizeof($sales))
                <tr>
                    <td colspan="7">
                        <div class="h5 text-center">
                            Sin resultados.
                        </div>
                    </td>
                </tr>
            @endif
            @foreach($sales as $sale)
            <tr class="text-center">
                <td>
                    <span class="h6">{{ $sale->id }}</span>
                </td>
                <td>
                    <span class="h6">{{ number_format($sale->total, 2) }}</span>
                </td>
                <td>
                    <span class="h6">{{ $sale->items }}</span>
                </td>
                <td>
                    <span class="h6">{{ $sale->status }}</span>
                </td>
                <td>
                    <span class="h6">{{ $sale->user->name }}</span>
                </td>
                <td>
                    <span class="h6">
                        {{ $sale->created_at->format('d/m/y') }}
                    </span>
                </td>
                <td width="50px">
                    <button 
                        class="btn btn-dark btn-sm"
                        type="button" 
                        wire:click.prevent="getDetails({{ $sale->id }})"
                    >
                        <i class="fa-solid fa-list"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>