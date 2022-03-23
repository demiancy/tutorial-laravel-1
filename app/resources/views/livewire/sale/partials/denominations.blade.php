<div class="row mt-3">
    <div class="col-12">
        <div class="connect-sorting">
            <h5 class="text-center mb-2">DENOMINACIONES</h5>
            <div class="container">
                <div class="row">
                    @foreach($denominations as $denomination)
                        <div class="col-6 col-md-4 mt-2">
                            <button 
                                class="btn btn-dark btn-block den px-0"
                                wire:click.prevent="addCash({{ $denomination->value }})"
                            >
                                ${{ number_format($denomination->value, 2) }}
                            </button>
                        </div>
                    @endforeach

                    <div class="col-12 mt-2">
                        <button 
                            class="btn btn-dark btn-block den"
                            wire:click.prevent="exactCash()"
                        >
                            Exacto
                        </button>
                    </div>
                </div>
            </div>

            <div class="connect-sorting-content mt-4">
                <div class="card simple-title-task ui-sortable-handle">
                    <div class="card-body">
                        <div class="input-group input-group-md mb-3">
                            <div class="input-group-prepend">
                                <span class="input-group-text input-gp hideonsm sale-denomination-input-side">
                                    Efectivo F8
                                </span>
                            </div>
                            <input 
                                type="number" 
                                class="form-control text-center" 
                                id="cash"
                                wire:model="object.cash"
                                wire:keydown.enter="saveSale"
                            >
                            <div class="input-group-append">
                                <span 
                                    class="input-group-text sale-denomination-input-side"
                                    wire:click.prevent="resetCash()"
                                >
                                    <i class="fa-solid fa-delete-left fa-2x"></i>
                                </span>
                            </div>
                        </div>

                        <div class="h4 text-muted">
                            Cambio: ${{ number_format($object->change, 2) }}
                        </div>

                        <div class="row justify-content-between mt-5">
                            @if ($object->total)
                                <div class="col-12 col-lg-6">
                                    <button 
                                        class="btn btn-dark btn-block mtmobile"
                                        onclick="confirm('clearCart', '', '¿CONFIRMAS CANCELAR LA COMPRA?')"
                                    >
                                        CANCELAR F4
                                    </button>
                                    
                                </div>

                                <div class="col-12 col-lg-6">
                                    @if ($object->cash >= $object->total)
                                        <button 
                                            class="btn btn-dark btn-block btn-md"
                                            wire:click.prevent="saveSale"
                                        >
                                            GUARDAR F9
                                        </button>
                                    @endif
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>