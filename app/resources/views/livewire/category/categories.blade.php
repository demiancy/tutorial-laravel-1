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
                    @can('create_categories')
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
                                <th class="table-th text-white">DESCRIPCION</th>
                                <th class="table-th text-white">IMAGEN</th>
                                <th class="table-th text-white">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td>
                                    <h6>{{ $category->name }}</h6>
                                </td>
                                <td class="text-center">
                                    <span>
                                        @include(
                                            'common.image', 
                                            [
                                                'image'   => $category->image, 
                                                'storage' => 'categories', 
                                                'alt'     => "Imagen de $category->name"
                                            ]
                                        )
                                    </span>
                                </td>
                                <td class="text-center">
                                    @can('update_categories')
                                        <a 
                                            href="javascript:void(0)" 
                                            class="btn btn-dark mtmobile" 
                                            title="Editar"
                                            wire:click="edit({{ $category->id }})"
                                        >
                                            <i class="fa-regular fa-pen-to-square"></i>
                                        </a>
                                    @endcan
                                    @can('delete_categories')
                                        <a 
                                            href="javascript:void(0)" 
                                            @if ($category->canDelete())
                                                class="btn btn-dark" 
                                                title="Borrar"
                                                onclick="confirm('deleteCategory', {{ $category->id }})"
                                            @else
                                                class="btn btn-dark disabled" 
                                                title="Esta categoria no puede ser borrada"
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
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.category.form')
</div>