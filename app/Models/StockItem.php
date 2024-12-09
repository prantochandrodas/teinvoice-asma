<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockItem extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item_id',
        'quantity',
        'unit_cost',
        'status',
        'admin_id',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['amount'];

    public function getAmountAttribute() {
        return $this->quantity * $this->unit_cost;
    }

    public function item() {
        return $this->belongsTo(Item::class);
    }

    public function admin() {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
