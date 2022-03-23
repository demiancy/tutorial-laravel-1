<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'price',
        'quantity',
        'sale_id',
        'product_id'
    ];

    /**
     * Sale
     */
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
