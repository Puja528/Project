<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinancialNote extends Model
{
    use HasFactory;

    protected $table = 'financial_notes'; // Explicitly define table name

    protected $fillable = [
        'user_id',
        'title',
        'amount',
        'category',
        'due_date',
        'description',
        'priority',
        'status'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'date'
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Accessors
    public function getCategoryNameAttribute()
    {
        $categories = [
            'urgent_important' => 'Mendesak & Penting',
            'not_urgent_important' => 'Tidak Mendesak & Penting',
            'urgent_not_important' => 'Mendesak & Tidak Penting',
            'not_urgent_not_important' => 'Tidak Mendesak & Tidak Penting'
        ];

        return $categories[$this->category] ?? $this->category;
    }

    public function getPriorityNameAttribute()
    {
        $priorities = [
            'low' => 'Rendah',
            'medium' => 'Sedang',
            'high' => 'Tinggi'
        ];

        return $priorities[$this->priority] ?? $this->priority;
    }

    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
