<div class="row sales layout-top-spacing">
    <div class="col-sm-12">
        <div class="widget widget-chart-one">
            <div class="widget-heading">
                <h4 class="card-title">
                    <span class="font-weight-bold">
                        {{ $componentName }} | {{ $pageTitle }}
                    </span>
                </h4>

                <ul class="tabs tab-pills">
                    <li>
                        <a 
                            href="javascript:void(0)" 
                            class="tabmenu bg-dark" 
                            data-toggle="modal" 
                            data-target="#theModal"
                        >
                            Agregar
                        </a>
                    </li>
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
                                        <img 
                                            src="{{ Storage::disk('categories')->url($category->image) }}" 
                                            alt="Imagen de {{ $category->name }}" 
                                            height="70" 
                                            width="80" 
                                            class="rounded"
                                        >
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a 
                                        href="javascript:void(0)" 
                                        class="btn btn-dark mtmobile" 
                                        title="Edit"
                                        wire:click="Edit({{ $category->id }})"
                                    >
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    <a 
                                        href="javascript:void(0)" 
                                        class="btn btn-dark" 
                                        title="Delete"
                                        onclick="Confirm({{ $category->id }})"
                                    >
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
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