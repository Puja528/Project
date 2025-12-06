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
        'start_date',
        'user_id',
    ];

    protected $dates = ['start_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessor untuk return percentage
    public function getReturnPercentageAttribute()
    {
        if ($this->initial_amount > 0) {
            return (($this->current_value - $this->initial_amount) / $this->initial_amount) * 100;
        }
        return 0;
    }
}
