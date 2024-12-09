<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'name',
        'price',
        'quantity',
        'tax',
        'price_without_tax',
        'purchase_price',
        'details',
        'image',
        'manufacture_date',
        'expiry_date',
        'status',
        'created_admin_id',
        'updated_admin_id',
    ];

    // Log Activity  Tracking Attribute
    protected static $logAttributes = [
        'code',
        'name',
        'price',
        'quantity',
        'tax',
        'price_without_tax',
        'details',
        'image',
        'manufacture_date',
        'expiry_date',
        'status',
    ];

    // Log Activity  Only changeable field Tracking
    protected static $logOnlyDirty = true;

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['image_path'];

    public function getImagePathAttribute() {
        return $this->image ? file_url($this->image, 'item') : "";
    }

    public function easy_sale_items() {
        return $this->hasMany(EasySaleItem::class);
    }

    public function easy_sale_item() {
        return $this->hasOne(EasySaleItem::class);
    }

    public function stock_item() {
        return $this->hasOne(StockItem::class);
    }

    public function created_admin() {
        return $this->belongsTo(Admin::class, 'created_admin_id');
    }

    public function update_admin() {
        return $this->belongsTo(Admin::class, 'updated_admin_id');
    }
    /**
     * Scope a query to only include active users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return void
     */
    public function scopeActive($query) {
        return $query->where('status', 1);
    }

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted() {
        // static::addGlobalScope(new ActiveScope);
    }

}
