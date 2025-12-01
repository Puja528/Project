<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    protected $table = 'debt';

    protected $fillable = [
        'user_id',
        'type',
        'person_name',
        'amount',
        'initial_amount',
        'due_date',
        'interest_rate',
        'status',
        'description'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'initial_amount' => 'decimal:2',
        'interest_rate' => 'decimal:2',
        'due_date' => 'date',
    ];

    // Accessor untuk cek apakah overdue
    public function getIsOverdueAttribute()
    {
        return $this->status === 'active' && $this->due_date < now();
    }
}
