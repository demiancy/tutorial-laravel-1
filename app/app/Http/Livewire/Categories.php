<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Category;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Categories extends Component
{
    use WithFileUploads;
    use WithPagination;
    use AuthorizesRequests;

    protected $paginationTheme = 'bootstrap';
    protected $listeners       = [
        'deleteCategory' => 'destroy'
    ];

    public ?Category $object;
    public string $search;
    public $image;
    public string $pageTitle;
    public string $componentName;
    public int $pagination;

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
        $this->authorize('viewAny', Category::class);

        if (strlen($this->search)) {
            $categories = Category::where('name', 'like', '%'.$this->search.'%')
                ->orderBy('id', 'desc');
        } else {
            $categories = Category::orderBy('id', 'desc');
        }

        return view('livewire.category.categories',[
            'categories' => $categories->paginate($this->pagination)
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    //Livewire need to defined rules for binding object.
    protected function rules()
    {
        //Unique validation need the id on update.
        $unique = 'unique:categories,name';
        if ($this->object->exists ?? false) {
            $unique .= ",{$this->object->id}";
        }

        return [
            'object.name'  => "required|string|$unique|min:3",
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function new()
    {
        $this->authorize('create', Category::class);

        $this->object = new Category();
        $this->image  = null;
        $this->emit('show-modal', 'show modal');
    }

    public function edit(Category $category)
    {
        $this->authorize('update', $category, Category::class);

        $this->object = $category;
        $this->image  = null;
        $this->emit('show-modal', 'show modal');
    }

    public function destroy(Category $category)
    {
        $this->authorize('delete', $category, Category::class);

        if ($category->canDelete()) {
            $category->delete();
            $this->resetPage();
        }
        
        $this->emit('noty', "La categoría {$category->name} fue eliminada correctamente");
        $this->resetUI();
    }

    public function resetUI()
    {
        $this->authorize('viewAny', Category::class);

        $this->object = null;
        $this->image  = null;
        $this->resetValidation();
        $this->emit('hide-modal', 'hide modal');
    }

    public function store()
    {
        $this->authorize('create', Category::class);

        $this->validate();

        if ($this->image) {
            $this->object->image = $this->image->store(null, 'categories');
        }

        $this->object->save();
        $this->emit('noty', 'Agregada nueva categoría');
        $this->resetUI();
    }

    public function update()
    {
        $this->authorize('update', $this->object, Category::class);

        $this->validate();

        if ($this->image) {
            //Remove old file.
            Storage::disk('categories')->delete($this->object->image);
            $this->object->image = $this->image->store(null, 'categories');
        }

        $this->object->save();
        $this->emit('noty', "La categoría {$this->object->name} fue actualizada correctamente");
        $this->resetUI();
    }
}