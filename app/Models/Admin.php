<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticable;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Permission;


class Admin extends Authenticable {

    use HasFactory,  HasRoles, LogsActivity, CausesActivity;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'phone',
        'password',
        'first_name',
        'last_name',
        'store_password',
        'address',
        'photo',
        'status',
        'email_verification',
        'phone_verification',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'store_password',
    ];


    // Log Activity  Tracking Attribute
    protected static $logAttributes = [
        'username',
        'email',
        'phone',
        'first_name',
        'last_name',
        'store_password',
        'address',
        'photo',
        'status',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['photo_path', 'full_name'];




    // Ignore Log Activity  Tracking Attribute
    protected static $ignoreChangedAttributes = [
        'remember_token',
        'updated_at'
    ];


    // Log Activity  Only changeable field Tracking
    protected static $logOnlyDirty = true;



    // protected static $logAttributes = [];

    //only the `deleted` event will get logged automatically
    // protected static $recordEvents = ['updated'];


    //only for add each time description
    // public function getDescriptionForEvent(string $eventName): string{
    //     return "This model has been {$eventName}";
    // }


    //only for add each log_name
    // protected static $logName = 'admin';

    //only for add each log_name
    //  protected static $ignoreChangedAttributes = ['status', 'updated_at'];




    /* public function setUsernameAttribute($value) {
    $this->attributes['username'] = preg_replace('#[ -]+#', '_', strtolower($value));
    } */


    public function getFullNameAttribute() {
        return "{$this->first_name} {$this->last_name}";
    }


    public function getPhotoPathAttribute() {
        return $this->photo ? file_url($this->photo , 'admin') : "";
    }


    public static function getPermissionGroups() {
        $permissionGroup = Permission::select('group_name as name')
            ->groupBy('group_name')
            ->orderBy('id')
            ->get();
        return $permissionGroup;
    }

    public static function getPermissionByGroupName($group_name) {
        $permissions = Permission::where('group_name', $group_name)
            ->get();
        return $permissions;
    }

    public static function roleHasPermissions($role, $permissions) {
        $hasPermission = true;

        foreach ($permissions as $permission) {

            if (!$role->hasPermissionTo($permission->name)) {
                $hasPermission = false;
                return $hasPermission;
            }

        }

        return $hasPermission;
    }

    public function getPermissionAttribute() {
        return $this->getAllPermissions();
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
