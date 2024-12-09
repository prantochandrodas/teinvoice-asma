<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnSale extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'sale_id',
        'customer_id',
        'note',
        'total_quantity',
        'grand_amount',
        'status',
        'created_admin_id',
        'updated_admin_id',
    ];

    public function return_sale_details() {
        return $this->hasMany(ReturnSaleDetail::class);
    }

    public function sale() {
        return $this->belongsTo(Sale::class);
    }

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function created_admin() {
        return $this->belongsTo(Admin::class, 'created_admin_id');
    }

    public function updated_admin() {
        return $this->belongsTo(Admin::class, 'updated_admin_id');
    }
}
