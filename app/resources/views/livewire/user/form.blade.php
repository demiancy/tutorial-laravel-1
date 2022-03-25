@include('common.modalHead')

<div class="row">
    <div class="col-12 col-md-8">
        <div class="form-group">
            <label>Nombre</label>
            <input 
                type="text" 
                wire:model.lazy="object.name" 
                class="form-control"
                placeholder="Ej: Admin"
            >
            @error('object.name')
                <span class="text-danger er">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="form-group">
            <label>Telefono</label>
            <input 
                type="text" 
                wire:model.lazy="object.phone" 
                class="form-control"
                placeholder="Ej: 3205588"
            >
            @error('object.phone')
                <span class="text-danger er">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Email</label>
            <input 
                type="email" 
                wire:model.lazy="object.email" 
                class="form-control"
                placeholder="Ej: 3205588"
            >
            @error('object.email')
                <span class="text-danger er">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Contraseña</label>
            <input 
                type="password" 
                wire:model.lazy="password" 
                class="form-control"
            >
            @error('password')
                <span class="text-danger er">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Estado</label>
            <select class="form-control" wire:model.lazy="object.status">
                <option value="">Elejir</option>
                <option value="ACTIVE">ACTIVE</option>
                <option value="LOCKED">LOCKED</option>
            </select>
            @error('object.status')
                <span class="text-danger er">
                    {{ $message }}
                </span>
            @enderror
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Rol</label>
            <select class="form-control" wire:model.lazy="selectedRole">
                <option value="">Elejir</option>
                @foreach($roles as $role)
                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                @endforeach
            </select>
            @error('selectedRole')
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