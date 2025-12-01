<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    protected $table = 'investment';

    protected $fillable = [
        'name',
        'type',
        'risk_level',
        'initial_amount',
        'current_value',
        'start_date'
    ];
}