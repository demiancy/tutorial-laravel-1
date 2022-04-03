<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Denomination;
use App\Models\Product;
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Sales extends Component
{
    use AuthorizesRequests;

    protected $listeners = [
        'scanCode'       => 'scanCode',
        'removeSaleItem' => 'removeSaleItem',
        'clearCart'      => 'clearCart',
        'saveSale'       => 'saveSale',
    ];

    public ?Sale $object;

    public function mount()
    {
        $this->resetSale();
    }

    public function render()
    {
        $this->authorize('sales', Sale::class);

        $denominations = Denomination::where('value', '>', 0)
            ->orderBy('value', 'desc')
            ->get();

        return view('livewire.sale.sales',[
            'denominations' => $denominations,
            'cart'          => Cart::getContent()->sortBy('name'),
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    //Livewire need to defined rules for binding object.
    protected function rules()
    {
        return [
            'object.total'   => "required|numeric|min:0",
            'object.cash'    => "required|numeric|min:0",
            'object.change'  => "required|numeric|min:0",
        ];
    }

    public function saveSale()
    {
        $this->authorize('sales', Sale::class);

        if ($this->validateSale()) {
            try {
                DB::beginTransaction();

                $this->object->items   = Cart::getTotalQuantity();
                $this->object->user_id = Auth()->user()->id;
                $this->object->save();

                foreach (Cart::getContent() as $item) {
                    $this->object->details()->save(
                        new SaleDetail([
                            'price'      => $item->price,
                            'quantity'   => $item->quantity,
                            'product_id' => $item->model->id,
                        ])
                    );

                    //Update stock
                    $product = $item->model;
                    $product->stock -= $item->quantity;
                    $product->save();
                }

                DB::commit();

                $this->emit('noty', "La venta se guardo con exito.");
                $this->emit('print-ticket', $this->object->id);

                $this->resetSale();
                Cart::clear();
            } catch(\Exception $exp) {
                DB::rollBack();
                $this->emit('error', $exp->getMessage());
            } 
        }
    }

    //Add a random product to sale.
    public function addProduct()
    {
        $this->authorize('sales', Sale::class);

        $this->scanCode(str_pad(random_int(1, 400), 9, 0, STR_PAD_LEFT), 1);
    }

    public function resetCash()
    {
        $this->authorize('sales', Sale::class);

        $this->object->cash   = 0;
        $this->object->change = 0;
    }

    public function exactCash()
    {
        $this->authorize('sales', Sale::class);

        $this->object->cash   = $this->object->total;
        $this->object->change = 0;
    }

    public function addCash(float $value)
    {
        $this->authorize('sales', Sale::class);

        $this->object->cash  += $value;
        $this->object->change = $this->object->cash - $this->object->total;
    }

    public function removeSaleItem(int $id) 
    {
        $this->authorize('sales', Sale::class);

        Cart::remove($id);
        $this->updateTotal();
    }

    public function decreaseQty(int $id)
    {
        $this->updateQty($id, -1, true);
    }

    public function increaseQty(int $id)
    {
        $this->updateQty($id, 1, true);
    }

    public function updateQty(int $id, int $cant, bool $relative = false)
    {
        $this->authorize('sales', Sale::class);

        if ($row = Cart::get($id)) {
            $product = Product::find($id);

            $this->updateItemCart($product, $cant, $row->quantity, $relative);
            $this->updateTotal();
        } else {
            $this->emit('error', "No existe un producto con ese identificador.");
        }
    }

    public function clearCart()
    {
        $this->authorize('sales', Sale::class);

        Cart::clear();
        $this->resetSale();
        $this->emit('noty', "Carrito vacio.");
    }

    public function scanCode(string $barcode = '', int $cant = 1)
    {
        $this->authorize('sales', Sale::class);

        $product = Product::byBarcode($barcode)->first();

        if (!$product) {
            $this->emit('error', "EL producto con codigo $barcode no existe.");
        } else {
            $this->addToCart($product, $cant);
        }
    }

    public function printTicket($sale)
    {
        $this->authorize('sales', Sale::class);

        return Redirect::to("print://$sale->id");
    }

    protected function addToCart(Product $product, int $cant = 0)
    {
        if ($row = Cart::get($product->id)) {
            $this->updateItemCart($product, $cant, $row->quantity, true);
        } else {
            $this->addItemCart($product, $cant);
        }

        $this->updateTotal();
    }

    protected function updateTotal()
    {
        $this->object->total  = Cart::getTotal();
        $this->object->change = $this->object->cash - $this->object->total;
    }

    protected function updateItemCart(Product $product, int $cant, int $inCart, bool $relative = false)
    {
        $value = $relative ? ($inCart + $cant) : $cant;

        if ($this->validateItemForCart($product, $value)) {
            Cart::update($product->id,[
                'quantity' => array(
                    'relative' => $relative,
                    'value'    => $cant
                )
            ]);
            $this->emit('noty', "Producto actualizado correctamente.");
        }
    }
    
    protected function addItemCart(Product $product, int $cant)
    {
        if ($this->validateItemForCart($product, $cant)) {
            Cart::add([
                'id'              => $product->id,
                'name'            => $product->name,
                'price'           => $product->price,
                'quantity'        => $cant,
                'associatedModel' => $product

            ]);
            $this->emit('noty', "Producto agregado correctamente.");
        }
    }

    protected function validateItemForCart(Product $product, int $cant)
    {
        if ($cant < 1) {
            $this->emit('error', "La cantidad no puede ser menor a 1.");
            return false;
        }

        if ($product->stock < $cant) {
            $this->emit('error', "EL producto con codigo {$product->name} no cuenta con stock suficiente.");
            return false;
        }

        return true;
    }

    protected function validateSale()
    {
        if (!$this->object->total)
        {
            $this->emit('error', "No se puede guardar una venta sin productos.");
            return false;
        }

        if ($this->object->total > $this->object->cash)
        {
            $this->emit('error', "El efectivo debe ser mayor o igual al total.");
            return false;
        }

        return true;
    }

    protected function resetSale()
    {
        $this->object = new Sale([
            'change'  => 0,
            'cash'    => 0,
            'total'   => Cart::getTotal(),
        ]);
    }
}