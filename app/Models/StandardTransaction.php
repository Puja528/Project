<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandardTransaction extends Model
{
    use HasFactory;

    protected $table = 'standard_transactions';

    protected $fillable = [
        'user_id',
        'description',
        'amount',
        'type',
        'category',
        'date',
        'notes'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'date' => 'date'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessors
    public function getFormattedAmountAttribute()
    {
        $prefix = $this->type === 'income' ? '+' : '-';
        return $prefix . ' Rp ' . number_format($this->amount, 0, ',', '.');
    }

    public function getTypeNameAttribute()
    {
        $types = [
            'income' => 'Pemasukan',
            'expense' => 'Pengeluaran'
        ];

        return $types[$this->type] ?? $this->type;
    }

    // Scopes
    public function scopeIncome($query)
    {
        return $query->where('type', 'income');
    }

    public function scopeExpense($query)
    {
        return $query->where('type', 'expense');
    }

    public function scopeThisMonth($query)
    {
        return $query->whereMonth('date', now()->month)
                    ->whereYear('date', now()->year);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
