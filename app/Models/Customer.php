<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;



    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'phone',
        'name',
        'email',
        'vat_no',
        'address',
        'image',
        'status',
        'created_admin_id',
        'updated_admin_id',
    ];

    // Log Activity  Tracking Attribute
    protected static $logAttributes = [
        'phone',
        'name',
        'vat_no',
        'email',
        'address',
        'image',
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
        return $this->image ? file_url($this->image, 'customer') : "";
    }

    public function created_admin() {
        return $this->belongsTo(Admin::class, 'created_admin_id');
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

}



