<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'purchase_id',
        'item_id',
        'price',
        'quantity',
        'amount',
    ];

    public function purchase() {
        return $this->belongsTo(Purchase::class);
    }
    public function item() {
        return $this->belongsTo(Item::class);
    }
}
