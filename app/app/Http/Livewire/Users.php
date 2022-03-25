<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class Users extends Component
{
    use WithFileUploads;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    protected $listeners       = [
        'deleteUser' => 'destroy'
    ];

    public ?User $object;
    public string $search;
    public $image;
    public string $pageTitle;
    public ?string $password;
    public string $componentName;
    public int $pagination;
    public $selectedRoles;

    public function mount()
    {
        $this->pageTitle     = 'Listado';
        $this->componentName = 'Usuarios';
        $this->pagination    = 5;
        $this->search        = '';
        $this->password      = '';
        $this->object        = null;
        $this->selectedRoles = [];
    }

    public function render()
    {
        if (strlen($this->search)) {
            $users = User::where('name', 'like', '%'.$this->search.'%')
                ->orWhere('email', 'like', '%'.$this->search.'%')
                ->orderBy('name', 'desc');
        } else {
            $users = User::orderBy('name', 'desc');
        }

        return view('livewire.user.users',[
            'users' => $users->paginate($this->pagination),
            'roles' => Role::all()
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    //Livewire need to defined rules for binding object.
    protected function rules()
    {
        //Unique validation need the id on update.
        $uniqueName  = 'unique:users,name';
        $uniqueEmail = 'unique:users,email';
        $required    = 'required|';
        if ($this->object->exists ?? false) {
            $uniqueName  .= ",{$this->object->id}";
            $uniqueEmail .= ",{$this->object->id}";
            $required     = ''; 
        }

        return [
            'object.name'     => "required|string|$uniqueName|min:3|max:255",
            'object.phone'    => "string|min:3|max:10",
            'object.email'    => "required|string|email:rfc,dns,filter|$uniqueEmail|min:1|max:255",
            'password'        => "{$required}string|max:255|min:8",
            'object.status'   => "required|string|max:255|in:ACTIVE,LOCKED",
            'object.profile'  => "required|string|max:255|in:ADMIN,EMPLOYEE",
            'selectedRoles'   => 'array',
            'selectedRoles.*' => 'required|string|exists:roles,name',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function new()
    {
        $this->object        = new User();
        $this->image         = null;
        $this->password      = '';
        $this->selectedRoles = [];
        $this->emit('show-modal', 'show modal');
    }

    public function edit(User $user)
    {
        $this->object        = $user;
        $this->image         = null;
        $this->password      = '';
        $this->selectedRoles = $user->getRoleNames();
        $this->emit('show-modal', 'show modal');
    }

    public function destroy(User $user)
    {
        if ($user->canDelete()) {
            $user->delete();
            $this->resetPage();
        }
        
        $this->emit('noty', "El Usuario {$user->name} fue eliminado correctamente");
        $this->resetUI();
    }

    public function resetUI()
    {
        $this->object        = null;
        $this->image         = null;
        $this->password      = '';
        $this->selectedRoles = [];
        $this->resetValidation();
        $this->emit('hide-modal', 'hide modal');
    }

    public function store()
    {
        $this->validate();

        try {
            DB::beginTransaction();

            if ($this->image) {
                $this->object->image = $this->image->store(null, 'users');
            }

            $this->object->password = $this->password;

            $this->object->save();
            $this->object->assignRole($this->selectedRoles);

            DB::commit();

            $this->emit('noty', 'Agregado nuevo usuario');

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

            if ($this->image) {
                //Remove old file.
                Storage::disk('users')->delete($this->object->image);
                $this->object->image = $this->image->store(null, 'users');
            }

            if ($this->password && strlen($this->password)) {
                $this->object->password = $this->password;
            }
    
            $this->object->save();
            $this->object->syncRoles($this->selectedRoles);

            DB::commit();

            $this->emit('noty', "El usuario {$this->object->name} fue actualizado correctamente");

        } catch(\Exception $exp) {
            DB::rollBack();
            $this->emit('error', $exp->getMessage());
        } 

        $this->resetUI();
    }
}