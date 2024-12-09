<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sale_id',
        'item_id',
        'item_name',
        'unit_cost',
        'price',
        'tax',
        'quantity',
        'amount',
        'return_quantity',
        'return_amount',
        'status',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['current_quantity'];

    public function getCurrentQuantityAttribute() {
        return $this->quantity - $this->return_quantity;
    }


    public function sale() {
        return $this->belongsTo(Sale::class);
    }

    public function item() {
        return $this->belongsTo(Item::class);
    }

}
