<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\Categories;
use App\Http\Livewire\Products;
use App\Http\Livewire\Denominations;
use App\Http\Livewire\Sales;
use App\Http\Livewire\Roles;
use App\Http\Livewire\Users;
use App\Http\Livewire\Cashout;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::get('/categories', Categories::class)->name('categories');
    Route::get('/products', Products::class)->name('products');
    Route::get('/denominations', Denominations::class)->name('denominations');
    Route::get('/sales', Sales::class)->name('sales');
    Route::get('/roles', Roles::class)->name('roles');
    Route::get('/users', Users::class)->name('users');
    Route::get('/cashout', Cashout::class)->name('cashout');
});

Route::redirect('/', '/sales');