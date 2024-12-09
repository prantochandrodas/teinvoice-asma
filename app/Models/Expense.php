<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    protected $guarded=[];

    public function expenseHead()
    {
        return $this->belongsTo(ExpenseHead::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
}
