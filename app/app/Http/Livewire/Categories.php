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

    public string $name;
    public string $search;
    public string $image;
    public string $pageTitle;
    public string $componentName;
    public int $selected_id;
    public int $pagination;

    public function mount()
    {
        $this->pageTitle     = 'Listado';
        $this->componentName = 'Categorías';
        $this->pagination    = 5;
        $this->search        = '';
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
}
