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

    public string $name;
    public string $search;
    public string $image;
    public string $pageTitle;
    public string $componentName;
    public int $selected_id;
    private int $pagination = 5;

    public function render()
    {
        $categories = Category::all();

        return view('livewire.category.categories',[
            'categories' => $categories
        ])
        ->extends('layouts.theme.app')
        -section('content');
    }
}
