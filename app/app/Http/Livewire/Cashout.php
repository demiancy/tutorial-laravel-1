<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Cashout extends Component
{
    use AuthorizesRequests;

    public string $componentName;
    public float $total;
    public int $userId;
    public ?string $fromDate = null;
    public ?string $toDate = null;
    public int $items;
    public $sales;
    public $details;

    public function mount()
    {
        $this->componentName = 'Cierre de caja';
        $this->total         = 0;
        $this->userId        = 0;
        $this->items         = 0;
        $this->sales         = [];
        $this->details       = [];
    }

    public function render()
    {
        $this->authorize('cashout', Sale::class);

        return view('livewire.cashout.cashout',[
            'users' => User::orderBy('name', 'desc')->get()
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    public function search()
    {
        $this->authorize('cashout', Sale::class);

        $from = Carbon::parse($this->fromDate)->startOfDay();
        $to   = Carbon::parse($this->toDate)->endOfDay();
        
        $this->sales = Sale::where('status', 'PAID')
            ->where('user_id', $this->userId)
            ->whereBetween('created_at', [$from, $to])
            ->get();
        
        if ($this->sales->count()) {
            $this->total = $this->sales->sum('total');
            $this->items = $this->sales->sum('items');
        } else {
            $this->total = 0;
            $this->items = 0;
        }
    }

    public function viewDetails(Sale $sale)
    {
        $this->authorize('cashout', Sale::class);

        $this->details = $sale->details()->get();
        $this->emit('show-modal', 'show modal');
    }

    public function print()
    {

    }
}
