<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuyProduct extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function buyProductDetails()
    {
        return $this->hasMany(BuyProductDetail::class);
    }
}
