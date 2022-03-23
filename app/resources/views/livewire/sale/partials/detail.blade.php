<div class="connect-sorting">
    <div class="connect-sorting-content">
        <div class="card simple-title-task ui-sortable-handle">
            <div class="card-body">
                @if ( !$cart->isEmpty() )
                    <div class="table-responsive tblscroll sale-details">
                        <table class="table table-bordered table-striped mt-1">
                            <thead class="text-white">
                                <tr>
                                    <th width="10%"></th>
                                    <th class="table-th text-white">DESCRIPCÍON</th>
                                    <th class="table-th text-white text-center">PRECIO</th>
                                    <th width="13%" class="table-th text-white text-center">CANT</th>
                                    <th class="table-th text-white text-center">IMPORTE</th>
                                    <th class="table-th text-white text-center">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cart as $index => $item)
                                    <tr>
                                        <td class="text-center table-th">
                                            <span>
                                                @include(
                                                    'common.image', 
                                                    [
                                                        'image'   => $item->associatedModel->image, 
                                                        'storage' => 'products', 
                                                        'alt'     => "Imagen de {$item->name}"
                                                    ]
                                                )
                                            </span>
                                        </td>
                                        <td>
                                            <h6>{{ $item->name }}</h6>
                                        </td>
                                        <td class="text-center">
                                            ${{ number_format($item->price, 0) }}
                                        </td>
                                        <td>
                                            <input 
                                                class="h6 form-control text-center"
                                                type="number" 
                                                id="item-{{ $item->id }}" 
                                                wire:change="updateQty({{ $item->id }}, $('#item-' + {{ $item->id }}).val())"
                                                value="{{ $item->quantity }}"
                                                min="1"
                                            >
                                        </td>
                                        <td class="text-center">
                                            <div class="h6">
                                                ${{ number_format(($item->price * $item->quantity), 2) }}
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            <a 
                                                href="javascript:void(0)" 
                                                class="btn btn-dark mbmobile" 
                                                title="Borrar"
                                                onclick="confirm('removeSaleItem', {{ $index }})"
                                            >
                                                <i class="fa-solid fa-trash"></i>
                                            </a>

                                            <a 
                                                href="javascript:void(0)" 
                                                class="btn btn-dark mbmobile" 
                                                title="Reducir cantidad"
                                                wire:click="decreaseQty({{ $index }})"
                                            >
                                                <i class="fa-solid fa-minus"></i>
                                            </a>

                                            <a 
                                                href="javascript:void(0)" 
                                                class="btn btn-dark mbmobile" 
                                                title="Incrementar cantidad"
                                                wire:click="increaseQty({{ $index }})"
                                            >
                                                <i class="fa-solid fa-plus"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="h5 text-center text-muted">
                        Agrega productos a la venta
                    </div>
                @endif

                <div 
                    class="h4 text-danger text-center" 
                    wire:loading.inline 
                    wire:target="saveSale"
                >
                    Guardando venta...
                </div>

            </div>
        </div>
    </div>   
</div>