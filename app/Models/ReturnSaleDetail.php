<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnSaleDetail extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'return_sale_id',
        'sale_detail_id',
        'item_id',
        'item_name',
        'unit_cost',
        'price',
        'quantity',
        'amount',
        'status',
    ];

    public function return_sale() {
        return $this->belongsTo(ReturnSale::class);
    }

    public function sale_detail() {
        return $this->belongsTo(SaleDetail::class);
    }

    public function item() {
        return $this->belongsTo(Item::class);
    }
}
