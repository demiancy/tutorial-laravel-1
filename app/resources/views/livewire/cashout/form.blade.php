<div class="widget-content">
    <div class="row">
        <div class="col-12 col-md-3">
            <div class="form-group">
                <label>Usuario</label>
                <select class="form-control" wire:model.lazy="userId">
                    <option value="0">Elejir</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                @error('userId')
                    <span class="text-danger er">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="form-group">
                <label>Fecha inicial</label>
                <input 
                    type="date" 
                    wire:model.lazy="fromDate" 
                    class="form-control"
                >
                @error('fromDate')
                    <span class="text-danger er">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="form-group">
                <label>Fecha final</label>
                <input 
                    type="date" 
                    wire:model.lazy="toDate" 
                    class="form-control"
                >
                @error('toDate')
                    <span class="text-danger er">
                        {{ $message }}
                    </span>
                @enderror
            </div>
        </div>

        <div class="col-12 col-md-3 align-self-center d-flex justify-content-around">
            @if ($userId && $fromDate && $toDate)
                <button 
                    class="btn btn-dark"
                    type="button" 
                    wire:click.prevent="search()"
                >
                    Consultar
                </button>
            @endif

            @if ($total)
                <button 
                    class="btn btn-dark"
                    type="button" 
                    wire:click.prevent="print()"
                >
                    Imprimir
                </button>
            @endif
        </div>
    </div>
</div>