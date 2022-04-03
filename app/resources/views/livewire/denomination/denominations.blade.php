<div class="row sales layout-top-spacing">
    <div class="col-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <span class="font-weight-bold">
                        {{ $componentName }} | {{ $pageTitle }}
                    </span>
                </h4>

                <ul class="tabs tab-pills">
                    @can('create_denominations')
                        <li>
                            <a 
                                href="javascript:void(0)" 
                                class="tabmenu bg-dark" 
                                wire:click="new()"
                            >
                                Agregar
                            </a>
                        </li>
                    @endcan
                </ul>
            </div>
            @include('common.searchBox')

            <div class="widget-content">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped mt-1">
                        <thead class="text-white">
                            <tr>
                                <th class="table-th text-white">TIPO</th>
                                <th class="table-th text-white text-center">VALOR</th>
                                <th class="table-th text-white text-center">IMAGEN</th>
                                <th class="table-th text-white text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($denominations as $denomination)
                            <tr>
                                <td>
                                    <h6>{{ $denomination->type }}</h6>
                                </td>
                                <td class="text-center">
                                    ${{ number_format($denomination->value, 2) }}
                                </td>
                                <td class="text-center">
                                    <span>
                                        @include(
                                            'common.image', 
                                            [
                                                'image'   => $denomination->image, 
                                                'storage' => 'denominations', 
                                                'alt'     => "Imagen de $denomination->name"
                                            ]
                                        )
                                    </span>
                                </td>
                                <td class="text-center">
                                    @can('update_denominations')
                                        <a 
                                            href="javascript:void(0)" 
                                            class="btn btn-dark mtmobile" 
                                            title="Editar"
                                            wire:click="edit({{ $denomination->id }})"
                                        >
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                    @endcan
                                    @can('delete_denominations')
                                        <a 
                                            href="javascript:void(0)" 
                                            @if ($denomination->canDelete())
                                                class="btn btn-dark" 
                                                title="Borrar"
                                                onclick="confirm('deleteDenomination', {{ $denomination->id }})"
                                            @else
                                                class="btn btn-dark disabled" 
                                                title="Esta Moneda no puede ser borrada"
                                                disabled
                                            @endif
                                        >
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $denominations->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.denomination.form')
</div>