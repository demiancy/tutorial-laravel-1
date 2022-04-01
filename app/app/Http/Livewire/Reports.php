<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Sale;
use Carbon\Carbon;

class Reports extends Component
{
    public string $componentName;
    public float $total;
    public int $userId;
    public ?string $fromDate = null;
    public ?string $toDate = null;
    public int $items;
    public $sales;
    public $details;
    public $sale = null;

    public function mount()
    {
        $this->componentName = 'Reportes de ventas';
        $this->total         = 0;
        $this->userId        = 0;
        $this->items         = 0;
        $this->sales         = [];
        $this->details       = [];
    }

    public function render()
    {
        $this->salesByDate();

        return view('livewire.reports.reports',[
            'users' => User::orderBy('name', 'asc')->get()
        ])
        ->extends('layouts.theme.app')
        ->section('content');
    }

    protected function salesByDate() 
    {
        if (!$this->fromDate && strlen($this->fromDate) && !$this->toDate && strlen($this->toDate)) {
            $this->emit('error', "Debe seleccionar fechas validas");
        } else {
            $from = Carbon::parse($this->fromDate)->startOfDay();
            $to   = Carbon::parse($this->toDate)->endOfDay();
            
            $query = Sale::whereBetween('created_at', [$from, $to]);

            if ($this->userId) {
                $query->where('user_id', $this->userId);
            }

            $this->sales = $query->get();
        }
    }

    public function getDetails(int $saleId = 0)
    {
        $this->sale = Sale::find($saleId);
        $this->details = $this->sale->details()->get();
        $this->emit('show-modal', 'show modal');
    }
}
