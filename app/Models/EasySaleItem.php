<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EasySaleItem extends Model {
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'item_id',
        'status',
        'admin_id',
    ];

    // Log Activity  Tracking Attribute
    protected static $logAttributes = [
        'item_id',
        'status',
    ];

    // Log Activity  Only changeable field Tracking
    protected static $logOnlyDirty = true;

    public function item() {
        return $this->belongsTo(Item::class, 'item_id');
    }
}
