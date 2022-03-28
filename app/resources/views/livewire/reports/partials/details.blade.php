<div wire:ignore.self class="modal fade" tabindex="-1" id="theModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <span class="font-weight-bold">Detalle de venta #{{ $sale?->id }}</span>
                </h5>
                <h6 class="text-center text-warning" wire:loading>
                    POR FAVOR ESPERE
                </h6>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white bg-dark">
                            <tr>
                                <th class="table-th text-white text-center">FOLIO</th>
                                <th class="table-th text-white text-center">PRODUCTO</th>
                                <th class="table-th text-white text-center">PRECIO</th>
                                <th class="table-th text-white text-center">CANT</th>
                                <th class="table-th text-white text-center">IMPORTE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($details as $detail)
                                <tr>
                                    <td class="text-center">
                                        <span class="h6">{{ $detail->id }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="h6">{{ $detail->product->name }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="h6">${{ number_format($detail->price, 2) }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="h6">{{ $detail->quantity }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="h6">${{ number_format($detail->total , 2) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            @if (sizeof($details))
                                <tr>
                                    <td colspan="3" class="text-center">
                                        <span class="h5 font-weight-bold">TOTALES</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="h5">{{ $details->sum('quantity') }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="h5">
                                            ${{ number_format($details->sum('total'), 2) }}
                                        </span>
                                    </td>
                                </tr>
                            @endif
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button 
                    class="btn btn-dark close-btn text-info"
                    type="button" 
                    data-dismiss="modal"
                >
                    Cerrar
                </button>
            </div>
        </div>
    </div>
</div>