@include('common.modalHead')

<div class="row">
    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Tipo</label>
            <select class="form-control" wire:model.lazy="object.type">
                <option value="">Elejir</option>
                <option value="BILLETE">BILLETE</option>
                <option value="MONEDA">MONEDA</option>
                <option value="OTRO">OTRO</option>
            </select>
            @error('object.type')
                <span class="text-danger er">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Valor</label>
            <input 
                type="number" 
                wire:model.lazy="object.value" 
                class="form-control"
                placeholder="Ej: 1.00"
            >
            @error('object.value')
                <span class="text-danger er">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-12">
        <div class="form-group custom-file">
            <input 
                type="file" 
                class="custom-file-input form-control" 
                wire:model="image" 
                accept="image/x-png, image/gif, image/jpeg"
            >
            <label class="custom-file-label">
                Imágen {{ $image ?? ($object->image ?? '') }}
            </label>

            @error('image')
                <span class="text-danger er">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>
</div>

@include('common.modalFooter')