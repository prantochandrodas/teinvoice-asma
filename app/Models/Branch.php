<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'active_status',
        'contact_number',
        'arabic_name',
        'email',
        'address',
        'vat_number',
        'cr_no',
    ];
}
