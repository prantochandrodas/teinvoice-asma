<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function saleInfo() {
        return $this->belongsTo(Sale::class,'sale_id');
    }

    public function customer() {
        return $this->belongsTo(Customer::class,'customer_id');
    }

    
    public function branch() {
        return $this->belongsTo(Branch::class,'branch_id');
    }
}
