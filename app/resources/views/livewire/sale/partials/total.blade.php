<div class="row">
    <div class="col-12">
        <div class="connect-sorting">
            <h5 class="text-center mb-3">RESUMEN DE VENTA</h5>
            <div class="connect-sorting-content">
                <div class="card simple-title-task ui-sortable-handle">
                    <div class="card-body">
                        <div class="task-header">
                            <div class="h2">TOTAL: ${{ number_format($object->total, 2) }}</div>
                            <input type="hidden" id="hidden-count" value="{{ $cart->count() }}">
                            <div class="h4 mt-3">Articulos: {{ $cart->count() }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</div>