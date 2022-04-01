<div class="row">
    <div class="col-12">
        <div class="h6">Elije el Usuario</div>
        <div class="form-group">
            <select class="form-control" wire:model.lazy="userId">
                <option value="0">Todos</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <div class="h6">Fecha desde</div>
            <input 
                type="text" 
                wire:model.lazy="fromDate" 
                class="form-control flatpickr"
                placeholder="Click para elejir"
            >
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <div class="h6">Fecha hasta</div>
            <input 
                type="text" 
                wire:model.lazy="toDate" 
                class="form-control flatpickr"
                placeholder="Click para elejir"
            >
        </div>
    </div>

    <div class="col-12">

        <button 
            class="btn btn-dark btn-block"
            type="button" 
            wire:click.prevent="$refresh"
        >
            Consultar
        </button>

        <a 
            href="{{ url("reports/pdf/$userId/$fromDate/$toDate") }}"
            class="btn btn-dark btn-block{{ !$sales->count() ? ' disabled' : '' }}"
            target="_blank"
        >
            Generar PDF
        <a 
            href="{{ url("reports/excel/$userId/$fromDate/$toDate") }}"
            class="btn btn-dark btn-block{{ !$sales->count() ? ' disabled' : '' }}"
            target="_blank"
        >
            Exportar a Excel
        </a>

    </div>

</div>