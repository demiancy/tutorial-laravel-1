<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;

class Categories extends Component
{
    use WithFileUploads;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public ?Category $object;
    public string $search;
    public $image;
    public string $pageTitle;
    public string $componentName;
    public int $pagination = 5;

    public function mount()
    {
        $this->pageTitle     = 'Listado';
        $this->componentName = 'Categorías';
        $this->pagination    = 5;
        $this->search        = '';
        $this->object        = null;
    }

    public function render()
    {
        if (strlen($this->search)) {
            $categories = Category::where('name', 'like', '%'.$this->search.'%')
                ->orderBy('id', 'desc')
                ->paginate($this->pagination);
        } else {
            $categories = Category::orderBy('id', 'desc')
                ->paginate($this->pagination);
        }

        return view('livewire.category.categories',[
            'categories' => $categories
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    protected function rules()
    {
        $unique = 'unique:categories,name';
        if (($this->object) && ($this->object->exists())) {
            $unique .= ",{$this->object->id}";
        }

        return [
            'object.name'  => "required|string|$unique|min:3",
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function new()
    {
        $this->object = new Category();
        $this->emit('show-modal', 'show modal');
    }

    public function edit(int $id)
    {
        $this->object = Category::find($id, ['id', 'name', 'image']);
        $this->image = $this->object->image;
        $this->emit('show-modal', 'show modal');
    }

    public function resetUI()
    {
        $this->object = null;
        $this->image  = null;
        $this->emit('hide-modal', 'hide modal');
    }

    public function save()
    {
        $this->validate();

        if ($this->image) {
            $this->object->image = $this->image->store(null, 'categories');
        }

        $this->object->save();
        $this->resetUI();
    }
}
