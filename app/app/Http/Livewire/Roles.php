<?php

namespace App\Http\Livewire;

use App\Models\Role;
use Spatie\Permission\Models\Permission;
use Livewire\WithPagination;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Roles extends Component
{
    use WithPagination;

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
        $this->object              = new Role();
        $this->selectedPermissions = [];
        $this->emit('show-modal', 'show modal');
    }

    public function edit(Role $role)
    {
        $this->object              = $role;
        $this->selectedPermissions = $role->getPermissionNames();

        $this->emit('show-modal', 'show modal');
    }

    public function destroy(Role $role)
    {
        if ($role->canDelete()) {
            $role->delete();
        }
        
        $this->emit('noty', "El rol {$role->name} fue eliminado correctamente");
        $this->resetUI();
    }

    public function resetUI()
    {
        $this->object              = null;
        $this->selectedPermissions = [];
        $this->resetValidation();
        $this->emit('hide-modal', 'hide modal');
    }

    public function store()
    {
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
