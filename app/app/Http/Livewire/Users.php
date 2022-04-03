<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Users extends Component
{
    use WithFileUploads;
    use WithPagination;
    use AuthorizesRequests;

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
    public ?string $selectedRole;

    public function mount()
    {
        $this->pageTitle     = 'Listado';
        $this->componentName = 'Usuarios';
        $this->pagination    = 5;
        $this->search        = '';
        $this->password      = '';
        $this->object        = null;
        $this->selectedRole  = '';
    }

    public function render()
    {
        $this->authorize('viewAny', User::class);

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

        //Required is only for new users.
        $required    = 'required|';
        if ($this->object->exists ?? false) {
            $uniqueName  .= ",{$this->object->id}";
            $uniqueEmail .= ",{$this->object->id}";
            $required     = ''; 
        }

        return [
            'object.name'   => "required|string|$uniqueName|min:3|max:255",
            'object.phone'  => "string|min:3|max:10",
            'object.email'  => "required|string|email:rfc,dns,filter|$uniqueEmail|min:1|max:255",
            'password'      => "{$required}string|max:255|min:8",
            'object.status' => "required|string|max:255|in:ACTIVE,LOCKED",
            'selectedRole'  => 'required|string|exists:roles,name',
            'image'         => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function new()
    {
        $this->authorize('create', User::class);

        $this->object        = new User();
        $this->image         = null;
        $this->password      = '';
        $this->selectedRole  = '';
        $this->emit('show-modal', 'show modal');
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user, User::class);

        $this->object       = $user;
        $this->image        = null;
        $this->password     = '';
        $this->selectedRole = $user->profile;

        $this->emit('show-modal', 'show modal');
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user, User::class);

        if ($user->canDelete()) {
            $user->delete();
            $this->resetPage();
        }
        
        $this->emit('noty', "El Usuario {$user->name} fue eliminado correctamente");
        $this->resetUI();
    }

    public function resetUI()
    {
        $this->authorize('viewAny', User::class);

        $this->object       = null;
        $this->image        = null;
        $this->password     = '';
        $this->selectedRole = '';
        $this->resetValidation();

        $this->emit('hide-modal', 'hide modal');
    }

    public function store()
    {
        $this->authorize('create', User::class);

        $this->validate();

        try {
            DB::beginTransaction();

            if ($this->image) {
                $this->object->image = $this->image->store(null, 'users');
            }

            $this->object->password = $this->password;

            $this->object->save();
            $this->object->assignRole($this->selectedRole);

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
        $this->authorize('update', $this->object, User::class);

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
            $this->object->syncRoles($this->selectedRole);

            DB::commit();

            $this->emit('noty', "El usuario {$this->object->name} fue actualizado correctamente");

        } catch(\Exception $exp) {
            DB::rollBack();
            $this->emit('error', $exp->getMessage());
        } 

        $this->resetUI();
    }
}