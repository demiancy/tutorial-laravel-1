<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Categories;
use App\Http\Livewire\Products;
use App\Http\Livewire\Denominations;
use App\Http\Livewire\Sales;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/categories', Categories::class)->name('categories');
    Route::get('/products', Products::class)->name('products');
    Route::get('/denominations', Denominations::class)->name('denominations');
    Route::get('/sales', Sales::class)->name('sales');
});