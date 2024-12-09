<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Traits\CausesActivity;

class Application extends Model {
    use HasFactory, LogsActivity, CausesActivity;

    protected $fillable = [
        'name',
        'contact_number',
        'arabic_name',
        'vat_percent',
        'develop_by',
        'email',
        'address',
        'photo',
        'favicon',
        'vat_number',
        'cr_no',
        'locale',
        'meta_author',
        'meta_keywords',
        'meta_description',
        'google_map',
        'admin_id',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['photo_path', 'favicon_path'];

    // Log Activity  Tracking Attribute
    protected static $logAttributes = [
        'name',
        'contact_number',
        'arabic_name',
        'vat_percent',
        'develop_by',
        'email',
        'address',
        'photo',
        'vat_number',
        'cr_no',
        'locale',
        'favicon',
        'meta_author',
        'meta_keywords',
        'meta_description',
        'google_map',
    ];

    // Ignore Log Activity  Tracking Attribute
    protected static $ignoreChangedAttributes = [
        'updated_at',
    ];

    // Log Activity  Only changeable field Tracking
    protected static $logOnlyDirty = true;

    public function getPhotoPathAttribute() {
        return $this->photo ? file_url($this->photo, 'application') : "";
    }

    public function getFaviconPathAttribute() {
        return $this->favicon ? file_url($this->favicon, 'application') : "";
    }

    public function admin() {
        return $this->belongsTo(Admin::class)->withDefault(['name' => 'Admin User']);
    }
}
