<?php
// app/Models/Debt.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'person_name',
        'amount',
        'initial_amount',
        'paid_amount',
        'due_date',
        'interest_rate',
        'description',
        'status'
    ];

    protected $casts = [
        'amount' => 'float',
        'initial_amount' => 'float',
        'paid_amount' => 'float',
        'interest_rate' => 'float',
        'due_date' => 'date'
    ];

    // Accessor untuk remaining amount
    public function getRemainingAmountAttribute()
    {
        return $this->amount - $this->paid_amount;
    }

    // Accessor untuk payment percentage
    public function getPaymentPercentageAttribute()
    {
        if ($this->initial_amount == 0) return 0;
        return ($this->paid_amount / $this->initial_amount) * 100;
    }

    // Accessor untuk formatted amounts
    public function getAmountFormattedAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    public function getInitialAmountFormattedAttribute()
    {
        return 'Rp ' . number_format($this->initial_amount, 0, ',', '.');
    }

    public function getPaidAmountFormattedAttribute()
    {
        return 'Rp ' . number_format($this->paid_amount, 0, ',', '.');
    }

    public function getRemainingAmountFormattedAttribute()
    {
        return 'Rp ' . number_format($this->remaining_amount, 0, ',', '.');
    }

    // Accessor untuk status badge color
    public function getStatusBadgeAttribute()
    {
        return [
            'active' => 'blue',
            'paid' => 'green',
            'overdue' => 'red'
        ][$this->status] ?? 'gray';
    }

    // Accessor untuk type badge color
    public function getTypeBadgeAttribute()
    {
        return $this->type === 'piutang' ? 'green' : 'red';
    }

    // Scope untuk type tertentu
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Scope untuk status tertentu
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    // Scope untuk overdue debts
    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())->where('status', 'active');
    }

    // Method untuk menandai sebagai lunas
    public function markAsPaid()
    {
        $this->update([
            'paid_amount' => $this->amount,
            'status' => 'paid'
        ]);
    }

    // Method untuk menambah pembayaran
    public function addPayment($amount)
    {
        $newPaidAmount = $this->paid_amount + $amount;
        $status = $newPaidAmount >= $this->amount ? 'paid' : 'active';

        $this->update([
            'paid_amount' => $newPaidAmount,
            'status' => $status
        ]);
    }
}
