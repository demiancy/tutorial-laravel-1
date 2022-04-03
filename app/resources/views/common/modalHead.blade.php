<div wire:ignore.self class="modal fade" tabindex="-1" id="theModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-dark">
                <h5 class="modal-title text-white">
                    <span class="font-weight-bold">{{ $componentName }}</span> | {{ ($object->exists ?? false) ? 'EDITAR' : 'CREAR'  }}
                </h5>
                <h6 class="text-center text-warning" wire:loading>
                    POR FAVOR ESPERE
                </h6>
            </div>
        <div class="modal-body">