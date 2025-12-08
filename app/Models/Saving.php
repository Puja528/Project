<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    use HasFactory;

    protected $table = 'savings'; // Explicitly define table name

    protected $fillable = [
        'user_id',
        'name',
        'target_amount',
        'current_amount',
        'target_date',
        'description',
        'progress_percentage'
    ];

    protected $casts = [
        'target_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
        'target_date' => 'date',
        'progress_percentage' => 'decimal:2'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessors
    public function getFormattedTargetAmountAttribute()
    {
        return 'Rp ' . number_format($this->target_amount, 0, ',', '.');
    }

    public function getFormattedCurrentAmountAttribute()
    {
        return 'Rp ' . number_format($this->current_amount, 0, ',', '.');
    }

    public function getRemainingAmountAttribute()
    {
        return max(0, $this->target_amount - $this->current_amount);
    }

    public function getFormattedRemainingAmountAttribute()
    {
        return 'Rp ' . number_format($this->remaining_amount, 0, ',', '.');
    }

    public function getDaysRemainingAttribute()
    {
        return now()->diffInDays($this->target_date, false);
    }

    public function getProgressColorAttribute()
    {
        if ($this->progress_percentage >= 100) {
            return 'bg-green-500';
        } elseif ($this->progress_percentage >= 75) {
            return 'bg-yellow-500';
        } elseif ($this->progress_percentage >= 50) {
            return 'bg-blue-500';
        } else {
            return 'bg-red-500';
        }
    }

    // Mutator untuk auto-calculate progress
    public function setCurrentAmountAttribute($value)
    {
        $this->attributes['current_amount'] = $value;
        $this->attributes['progress_percentage'] = $this->target_amount > 0
            ? min(100, ($value / $this->target_amount) * 100)
            : 0;
    }

    public function setTargetAmountAttribute($value)
    {
        $this->attributes['target_amount'] = $value;
        $this->attributes['progress_percentage'] = $value > 0
            ? min(100, ($this->current_amount / $value) * 100)
            : 0;
    }

    // Scopes
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeCompleted($query)
    {
        return $query->where('progress_percentage', '>=', 100);
    }

    public function scopeInProgress($query)
    {
        return $query->where('progress_percentage', '<', 100);
    }
}
