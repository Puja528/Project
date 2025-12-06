<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $table = 'budgets';

    protected $fillable = [
        'budget_name',
        'category',
        'date',
        'allocated_amount',
        'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
