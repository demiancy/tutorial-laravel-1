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
                                <th class="table-th text-white">USUARIO</th>
                                <th class="table-th text-white text-center">TELEFONO</th>
                                <th class="table-th text-white text-center">EMAIL</th>
                                <th class="table-th text-white text-center">PERFIL</th>
                                <th class="table-th text-white text-center">ESTADO</th>
                                <th class="table-th text-white text-center">IMAGEN</th>
                                <th class="table-th text-white text-center">ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                            <tr>
                                <td>
                                    <h6>{{ $user->name }}</h6>
                                </td>
                                <td class="text-center">{{ $user->phone }}</td>
                                <td class="text-center">{{ $user->email }}</td>
                                <td class="text-center">{{ $user->profile }}</td>
                                <td class="text-center">
                                    <span class="badge badge-{{ $user->status == 'ACTIVE' ? 'success' : 'danger' }} text-uppercase">
                                        {{ $user->status }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <span>
                                        @include(
                                            'common.image', 
                                            [
                                                'image'   => $user->image, 
                                                'storage' => 'users', 
                                                'alt'     => "Imagen de $user->name"
                                            ]
                                        )
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a 
                                        href="javascript:void(0)" 
                                        class="btn btn-dark mtmobile" 
                                        title="Editar"
                                        wire:click="edit({{ $user->id }})"
                                    >
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                    <a 
                                        href="javascript:void(0)" 
                                        @if ($user->canDelete())
                                            class="btn btn-dark" 
                                            title="Borrar"
                                            onclick="confirm('deleteUser', {{ $user->id }})"
                                        @else
                                            class="btn btn-dark disabled" 
                                            title="Este Usuario no puede ser borrado"
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
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
    @include('livewire.user.form')
</div>