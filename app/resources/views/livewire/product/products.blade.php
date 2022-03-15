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
                            wire:click="new()"
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
                                <th class="table-th text-white text-center">BARCODE</th>
                                <th class="table-th text-white text-center">CATEGORÍA</th>
                                <th class="table-th text-white text-center">PRECIO</th>
                                <th class="table-th text-white text-center">STOCK</th>
                                <th class="table-th text-white text-center">INV.MIN</th>
                                <th class="table-th text-white text-center">IMAGEN</th>
                                <th class="table-th text-white text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr>
                                <td>
                                    <h6>{{ $product->name }}</h6>
                                </td>
                                <td class="text-center">{{ $product->barcode }}</td>
                                <td class="text-center">{{ $product->category->name }}</td>
                                <td class="text-center">{{ $product->price }}</td>
                                <td class="text-center">{{ $product->stock }}</td>
                                <td class="text-center">{{ $product->alerts }}</td>
                                <td class="text-center">
                                    <span>
                                        @include(
                                            'common.image', 
                                            [
                                                'image'   => $product->image, 
                                                'storage' => 'products', 
                                                'alt'     => "Imagen de $product->name"
                                            ]
                                        )
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a 
                                        href="javascript:void(0)" 
                                        class="btn btn-dark mtmobile" 
                                        title="Editar"
                                        wire:click="edit({{ $product->id }})"
                                    >
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    <a 
                                        href="javascript:void(0)" 
                                        @if ($product->canDelete())
                                            class="btn btn-dark" 
                                            title="Borrar"
                                            onclick="confirm('deleteProduct', {{ $product->id }})"
                                        @else
                                            class="btn btn-dark disabled" 
                                            title="Este Producto no puede ser borrado"
                                            disabled
                                        @endif
                                    >
                                        <i class="fa-solid fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $products->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.product.form')
</div>