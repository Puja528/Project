<?php
// app/Models/Transaction.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user',
        'amount',
        'type',
        'category',
        'date'
    ];

    protected $casts = [
        'date' => 'date'
        // Hapus casting untuk amount
    ];

    public static function getCategories()
    {
        return [
            'gaji' => 'Gaji',
            'investasi' => 'Investasi',
            'bonus' => 'Bonus',
            'belanja' => 'Belanja',
            'transportasi' => 'Transportasi',
            'hiburan' => 'Hiburan',
            'kesehatan' => 'Kesehatan',
            'pendidikan' => 'Pendidikan',
            'lainnya' => 'Lainnya'
        ];
    }

    public function getTypeBadgeAttribute()
    {
        return $this->type === 'income' ? 'success' : 'danger';
    }

    public function getTypeTextAttribute()
    {
        return $this->type === 'income' ? 'Income' : 'Expense';
    }

    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }
}
