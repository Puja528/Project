<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    protected $table = 'budget';

    protected $fillable = [
        'budget_name',
        'category',
        'period',
        'allocated_amount',
        'description'
    ];
}