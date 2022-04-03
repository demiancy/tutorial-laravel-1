<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Denomination;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Denominations extends Component
{
    use WithFileUploads;
    use WithPagination;
    use AuthorizesRequests;

    protected $paginationTheme = 'bootstrap';
    protected $listeners       = [
        'deleteDenomination' => 'destroy'
    ];

    public ?Denomination $object;
    public string $search;
    public $image;
    public string $pageTitle;
    public string $componentName;
    public int $pagination;

    public function mount()
    {
        $this->pageTitle     = 'Listado';
        $this->componentName = 'Monedas';
        $this->pagination    = 5;
        $this->search        = '';
        $this->object        = null;
    }

    public function render()
    {
        $this->authorize('viewAny', Denomination::class);

        if (strlen($this->search)) {
            $denominations = Denomination::where('type', 'like', '%'.$this->search.'%')
                ->orderBy('id', 'desc');
        } else {
            $denominations = Denomination::orderBy('id', 'desc');
        }

        return view('livewire.denomination.denominations',[
            'denominations' => $denominations->paginate($this->pagination)
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    //Livewire need to defined rules for binding object.
    protected function rules()
    {
        return [
            'object.type'  => "required|string",
            'object.value' => "required|numeric|min:0",
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function new()
    {
        $this->authorize('create', Denomination::class);

        $this->object = new Denomination();
        $this->image  = null;
        $this->emit('show-modal', 'show modal');
    }

    public function edit(Denomination $denomination)
    {
        $this->authorize('update', $denomination, Denomination::class);

        $this->object = $denomination;
        $this->image  = null;
        $this->emit('show-modal', 'show modal');
    }

    public function destroy(Denomination $denomination)
    {
        $this->authorize('delete', $denomination, Denomination::class);

        if ($denomination->canDelete()) {
            $denomination->delete();
            $this->resetPage();
        }
        
        $this->emit('noty', "La moneda fue eliminada correctamente");
        $this->resetUI();
    }

    public function resetUI()
    {
        $this->authorize('viewAny', Denomination::class);

        $this->object = null;
        $this->image  = null;
        $this->resetValidation();
        $this->emit('hide-modal', 'hide modal');
    }

    public function store()
    {
        $this->authorize('create', Denomination::class);

        $this->validate();

        if ($this->image) {
            $this->object->image = $this->image->store(null, 'denominations');
        }

        $this->object->save();
        $this->emit('noty', 'Agregada nueva moneda');
        $this->resetUI();
    }

    public function update()
    {
        $this->authorize('update', $this->object, Denomination::class);

        $this->validate();

        if ($this->image) {
            //Remove old file.
            Storage::disk('denominations')->delete($this->object->image);
            $this->object->image = $this->image->store(null, 'denominations');
        }

        $this->object->save();
        $this->emit('noty', "La moneda fue actualizada correctamente");
        $this->resetUI();
    }
}
