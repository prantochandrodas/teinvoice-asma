<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'company_name',
        'email',
        'contact_number',
        'address',
        'image',
        'balance',
        'status',
        'created_admin_id',
        'updated_admin_id'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'image_path',
    ];


    public function getImagePathAttribute() {
        return $this->image ? file_url($this->image, 'supplier') : "";
    }

    public function created_admin() {
        return $this->belongsTo(Admin::class, 'created_admin_id', 'id')->withDefault(['name' => 'Created Admin User']);
    }

    public function updated_admin() {
        return $this->belongsTo(Admin::class, 'updated_admin_id', 'id')->withDefault(['name' => 'Updated Admin User']);
    }


    /**
     * Scope a query to only include Active
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
