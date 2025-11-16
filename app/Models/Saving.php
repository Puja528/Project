<?php
// app/Models/Saving.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Saving extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'target_amount',
        'current_amount',
        'target_date',
        'description',
        'status',
        'color',
        'icon',
        'monthly_target'
    ];

    protected $casts = [
        'target_amount' => 'float',
        'current_amount' => 'float',
        'monthly_target' => 'float',
        'target_date' => 'date'
    ];

    // Accessor untuk progress percentage
    public function getProgressPercentageAttribute()
    {
        if ($this->target_amount == 0) return 0;
        return min(100, ($this->current_amount / $this->target_amount) * 100);
    }

    // Accessor untuk remaining amount
    public function getRemainingAmountAttribute()
    {
        return max(0, $this->target_amount - $this->current_amount);
    }

    // Accessor untuk days remaining
    public function getDaysRemainingAttribute()
    {
        return max(0, Carbon::now()->diffInDays($this->target_date, false));
    }

    // Accessor untuk months remaining
    public function getMonthsRemainingAttribute()
    {
        return max(0, Carbon::now()->diffInMonths($this->target_date, false));
    }

    // Accessor untuk formatted amounts
    public function getTargetAmountFormattedAttribute()
    {
        return 'Rp ' . number_format($this->target_amount, 0, ',', '.');
    }

    public function getCurrentAmountFormattedAttribute()
    {
        return 'Rp ' . number_format($this->current_amount, 0, ',', '.');
    }

    public function getRemainingAmountFormattedAttribute()
    {
        return 'Rp ' . number_format($this->remaining_amount, 0, ',', '.');
    }

    public function getMonthlyTargetFormattedAttribute()
    {
        return $this->monthly_target ? 'Rp ' . number_format($this->monthly_target, 0, ',', '.') : '-';
    }

    // Accessor untuk status badge color
    public function getStatusBadgeAttribute()
    {
        return [
            'active' => 'blue',
            'completed' => 'green',
            'cancelled' => 'red'
        ][$this->status] ?? 'gray';
    }

    // Accessor untuk status text
    public function getStatusTextAttribute()
    {
        return [
            'active' => 'Aktif',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan'
        ][$this->status] ?? 'Tidak Diketahui';
    }

    // Accessor untuk progress color based on status and progress
    public function getProgressColorAttribute()
    {
        if ($this->status === 'completed') return 'green';
        if ($this->status === 'cancelled') return 'red';

        if ($this->progress_percentage >= 100) return 'green';
        if ($this->progress_percentage >= 75) return 'yellow';
        if ($this->progress_percentage >= 50) return 'blue';
        if ($this->progress_percentage >= 25) return 'purple';
        return 'red';
    }

    // Method untuk calculate monthly target automatically
    public function calculateMonthlyTarget()
    {
        $monthsRemaining = $this->months_remaining;
        if ($monthsRemaining > 0) {
            $this->monthly_target = $this->remaining_amount / $monthsRemaining;
        } else {
            $this->monthly_target = $this->remaining_amount;
        }
        return $this->monthly_target;
    }

    // Method untuk add amount to savings
    public function addAmount($amount)
    {
        $this->current_amount += $amount;

        // Auto complete if target reached
        if ($this->current_amount >= $this->target_amount) {
            $this->current_amount = $this->target_amount;
            $this->status = 'completed';
        }

        $this->save();
    }

    // Scope untuk active savings
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Scope untuk completed savings
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    // Scope untuk overdue savings (target date passed but not completed)
    public function scopeOverdue($query)
    {
        return $query->where('target_date', '<', now())
                    ->where('status', 'active');
    }

    // Boot method untuk auto calculate monthly target
    protected static function boot()
    {
        parent::boot();

        static::saving(function ($model) {
            if ($model->isDirty(['target_amount', 'current_amount', 'target_date'])) {
                $model->calculateMonthlyTarget();
            }
        });
    }
}
