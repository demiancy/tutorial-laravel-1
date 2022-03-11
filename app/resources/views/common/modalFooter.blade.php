            </div>
            <div class="modal-footer">
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info" data-dismiss="modal">
                    CERRAR
                </button>

                @if ($object->exists ?? false)
                    <button type="button" wire:click.prevent="update()" class="btn btn-dark close-modal">
                        ACTUALIZAR
                    </button>
                @else
                    <button type="button" wire:click.prevent="store()" class="btn btn-dark close-modal">
                        GUARDAR
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>