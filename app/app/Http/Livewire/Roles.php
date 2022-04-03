<?php

namespace App\Http\Livewire;

use App\Models\Role;
use Spatie\Permission\Models\Permission;
use Livewire\WithPagination;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Roles extends Component
{
    use WithPagination;
    use AuthorizesRequests;

    protected $paginationTheme = 'bootstrap';
    protected $listeners       = [
        'deleteRole' => 'destroy'
    ];

    public ?Role $object;
    public string $search;
    public string $pageTitle;
    public string $componentName;
    public int $pagination;
    public $selectedPermissions;

    public function mount()
    {
        $this->pageTitle           = 'Listado';
        $this->componentName       = 'Roles';
        $this->pagination          = 5;
        $this->search              = '';
        $this->object              = null;
        $this->selectedPermissions = [];
    }

    public function render()
    {
        $this->authorize('viewAny', Role::class);

        if (strlen($this->search)) {
            $roles = Role::where('name', 'like', '%'.$this->search.'%')
                ->orderBy('name', 'desc');
        } else {
            $roles = Role::orderBy('name', 'desc');
        }

        return view('livewire.role.roles',[
            'roles'       => $roles->paginate($this->pagination),
            'permissions' => Permission::all()
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    //Livewire need to defined rules for binding object.
    protected function rules()
    {
        //Unique validation need the id on update.
        $unique = 'unique:roles,name';
        if ($this->object->exists ?? false) {
            $unique  .= ",{$this->object->id}";
        }
        
        return [
            'object.name'           => "required|string|$unique|min:2",
            'selectedPermissions'   => 'array',
            'selectedPermissions.*' => 'required|string|exists:permissions,name'
        ];
    }

    public function new()
    {
        $this->authorize('create', Role::class);

        $this->object              = new Role();
        $this->selectedPermissions = [];
        $this->emit('show-modal', 'show modal');
    }

    public function edit(Role $role)
    {
        $this->authorize('update', $role, Role::class);

        $this->object              = $role;
        $this->selectedPermissions = $role->getPermissionNames();

        $this->emit('show-modal', 'show modal');
    }

    public function destroy(Role $role)
    {
        $this->authorize('delete', $role, Role::class);

        if ($role->canDelete()) {
            $role->delete();
            $this->resetPage();
        }
        
        $this->emit('noty', "El rol {$role->name} fue eliminado correctamente");
        $this->resetUI();
    }

    public function resetUI()
    {
        $this->authorize('viewAny', Role::class);

        $this->object              = null;
        $this->selectedPermissions = [];
        $this->resetValidation();
        $this->emit('hide-modal', 'hide modal');
    }

    public function store()
    {
        $this->authorize('create', Role::class);

        $this->validate();

        try {
            DB::beginTransaction();

            $this->object->save();
            $this->object->givePermissionTo($this->selectedPermissions);

            DB::commit();

            $this->emit('noty', "Agregado el rol {$this->object->name}");

        } catch(\Exception $exp) {
            DB::rollBack();
            $this->emit('error', $exp->getMessage());
        } 

        $this->resetUI();
    }

    public function update()
    {
        $this->authorize('update', $this->object, Role::class);

        $this->validate();

        try {
            DB::beginTransaction();

            $this->object->save();
            $this->object->syncPermissions($this->selectedPermissions);

            DB::commit();

            $this->emit('noty', "El rol {$this->object->name} fue actualizado correctamente");

        } catch(\Exception $exp) {
            DB::rollBack();
            $this->emit('error', $exp->getMessage());
        } 

        $this->resetUI();
    }
}
