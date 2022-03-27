<div wire:ignore.self class="modal fade" tabindex="-1" id="theModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <span class="font-weight-bold">Detalle de ventas</span>
                </h5>
                <button 
                    class="close"
                    type="button" 
                    data-dismiss="modal"
                    aria-label="close"
                >
                    <span class="text-white" aria-hidden="true">&times;</span>
                </button>
                <h6 class="text-center text-warning" wire:loading>
                    POR FAVOR ESPERE
                </h6>
            </div>
            <div class="modal-body">

                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white bg-dark">
                            <tr>
                                <th class="table-th text-white text-center">PRODUCTO</th>
                                <th class="table-th text-white text-center">CANT</th>
                                <th class="table-th text-white text-center">PRECIO</th>
                                <th class="table-th text-white text-center">IMPORTE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($details as $detail)
                                <tr>
                                    <td class="text-center">
                                        <span class="h6">{{ $detail->product->name }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="h6">{{ $detail->quantity }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="h6">${{ number_format($detail->price, 2) }}</span>
                                    </td>
                                    <td class="text-center">
                                        <span class="h6">${{ number_format($detail->total , 2) }}</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                        <tfoot>
                            @if ($details)
                                <td class="text-right">
                                    <span class="h6 text-info">TOTALES: </span>
                                </td>
                                <td class="text-center">
                                    <span class="h6 text-info">{{ $details->sum('quantity') }}</span>
                                </td>
                                <td></td>
                                <td class="text-center">
                                    <span class="h6 text-info">${{ number_format($details->sum('total'), 2) }}</span>
                                </td>
                            @endif
                        </tfoot>
                    </table>
                </div>


            </div>
        </div>
    </div>
</div>