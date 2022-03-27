<div class="row sales layout-top-spacing">
    <div class="col-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <span class="font-weight-bold">
                        {{ $componentName }}
                    </span>
                </h4>
            </div>

            @include('livewire.cashout.form')

            <div class="row mt-5">
                <div class="col-12 col-md-4 mbmobile">
                    <div class="connect-sorting bg-dark text-white">
                        <div class="h5">
                            Ventas totales: ${{ number_format($total, 2) }}
                        </div>
                        <div class="h5">
                            Articulos: ${{ $items }}
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-8">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white">
                            <tr>
                                <th class="table-th text-white text-center">FOLIO</th>
                                <th class="table-th text-white text-center">TOTAL</th>
                                <th class="table-th text-white text-center">ITEMS</th>
                                <th class="table-th text-white text-center">FECHA</th>
                                <th class="table-th text-white text-center"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$total)
                                <tr>
                                    <td colspan="5">
                                        <div class="h6 text-center">
                                            No hay ventas en la fecha seleccionada.
                                        </div>
                                    </td>
                                </tr>
                            @endif
                            @foreach($sales as $sale)
                                <tr>
                                    <td class="text-center">
                                        <span class="h6">{{ $sale->id }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="h6">${{ number_format($sale->total, 2) }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="h6">{{ $sale->items }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="h6">{{ $sale->created_at }}</span>
                                    </td>
                                    <td class="text-center">
                                        <button 
                                            class="btn btn-sm btn-dark"
                                            type="button" 
                                            wire:click.prevent="viewDetails({{ $sale }})"
                                        >
                                            <i class="fa-solid fa-list"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('livewire.cashout.modalDetails')
</div>