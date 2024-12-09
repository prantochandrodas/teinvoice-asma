<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'time',
        'bill_no',
        'bill_type',
        'customer_id',
        'branch_id',
        'note',
        'total_quantity',
        'grand_amount',
        'discount_amount',
        'tax_amount',
        'final_amount',
        'total_unit_cost',
		'return_total_quantity',
		'return_total_amount',
		'payment_type',
        'status',
        'created_admin_id',
        'updated_admin_id',
    ];

       /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['current_quantity'];

    public function getCurrentQuantityAttribute() {
        return $this->total_quantity - $this->return_total_quantity;
    }



    public function sale_details() {
        return $this->hasMany(SaleDetail::class);
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
