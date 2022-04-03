<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Products extends Component
{
    use WithFileUploads;
    use WithPagination;
    use AuthorizesRequests;

    protected $paginationTheme = 'bootstrap';
    protected $listeners       = [
        'deleteProduct' => 'destroy'
    ];

    public ?Product $object;
    public string $search;
    public $image;
    public string $pageTitle;
    public string $componentName;
    public int $pagination;

    public function mount()
    {
        $this->pageTitle     = 'Listado';
        $this->componentName = 'Productos';
        $this->pagination    = 5;
        $this->search        = '';
        $this->object        = null;
    }

    public function render()
    {
        $this->authorize('viewAny', Product::class);

        if (strlen($this->search)) {
            $products = Product::where('name', 'like', '%'.$this->search.'%')
                ->orWhere('barcode', 'like', '%'.$this->search.'%')
                ->orCategoryName($this->search)
                ->orderBy('id', 'desc');
        } else {
            $products = Product::orderBy('id', 'desc');
        }

        return view('livewire.product.products',[
            'products'   => $products->paginate($this->pagination),
            'categories' => Category::orderBy('name', 'desc')->get()
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    //Livewire need to defined rules for binding object.
    protected function rules()
    {
        //Unique validation need the id on update.
        $uniqueName = 'unique:products,name';
        $uniqueCode = 'unique:products,barcode';
        if ($this->object->exists ?? false) {
            $uniqueName .= ",{$this->object->id}";
            $uniqueCode .= ",{$this->object->id}";
        }

        return [
            'object.name'        => "required|string|$uniqueName|min:3",
            'object.barcode'     => "required|string|$uniqueCode|min:1",
            'object.cost'        => "required|numeric|min:0",
            'object.price'       => "required|numeric|min:0",
            'object.stock'       => "required|numeric|min:0",
            'object.alerts'      => "required|numeric|min:0",
            'object.category_id' => 'required|integer|min:1|exists:categories,id',
            'image'              => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function new()
    {
        $this->authorize('create', Product::class);

        $this->object = new Product();
        $this->image  = null;
        $this->emit('show-modal', 'show modal');
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product, Product::class);

        $this->object = $product;
        $this->image  = null;
        $this->emit('show-modal', 'show modal');
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product, Product::class);

        if ($product->canDelete()) {
            $product->delete();
            $this->resetPage();
        }
        
        $this->emit('noty', "El producto {$product->name} fue eliminado correctamente");
        $this->resetUI();
    }

    public function resetUI()
    {
        $this->authorize('viewAny', Product::class);

        $this->object = null;
        $this->image  = null;
        $this->resetValidation();
        $this->emit('hide-modal', 'hide modal');
    }

    public function store()
    {
        $this->authorize('create', Product::class);

        $this->validate();

        if ($this->image) {
            $this->object->image = $this->image->store(null, 'products');
        }

        $this->object->save();
        $this->emit('noty', 'Agregado nuevo producto');
        $this->resetUI();
    }

    public function update()
    {
        $this->authorize('update', $this->object, Product::class);

        $this->validate();

        if ($this->image) {
            //Remove old file.
            Storage::disk('products')->delete($this->object->image);
            $this->object->image = $this->image->store(null, 'products');
        }

        $this->object->save();
        $this->emit('noty', "El producto {$this->object->name} fue actualizado correctamente");
        $this->resetUI();
    }
}