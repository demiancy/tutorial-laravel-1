<div class="row sales layout-top-spacing">
    <div class="col-12 col-md-8">
        <div class="text-center mb-3">
            <a 
                href="javascript:void(0)" 
                class="btn btn-dark mbmobile" 
                title="Incrementar cantidad"
                wire:click="addProduct()"
            >
                Agregar producto aleatorio <i class="fa-solid fa-plus"></i>
            </a>
        </div>

        @include('livewire.sale.partials.detail')
    </div>
    <div class="col-12 col-md-4">
        @include('livewire.sale.partials.total')
        @include('livewire.sale.partials.denominations')
    </div>
</div>

<script>
    
    window.onload = function() {
        initPosKeypress();
        initOnScan();
    };
</script>


