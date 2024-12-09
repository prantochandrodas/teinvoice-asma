<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'time',
        'invoice_no',
        'supplier_id',
        'note',
        'total_quantity',
        'grand_amount',
        'discount_amount',
        'final_amount',
        'status',
        'created_admin_id',
        'updated_admin_id',
    ];

    public function supplier() {
        return $this->belongsTo(Supplier::class);
    }

    public function purchase_items() {
        return $this->hasMany(PurchaseItem::class);
    }

    public function created_admin() {
        return $this->belongsTo(Admin::class, 'created_admin_id');
    }

    public function update_admin() {
        return $this->belongsTo(Admin::class, 'updated_admin_id');
    }

}
