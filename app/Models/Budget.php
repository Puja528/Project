<?php
// app/Models/Budget.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'month_year',
        'allocated_amount',
        'used_amount',
        'description'
    ];

    // Hapus semua casting untuk menghindari error
    // protected $casts = [];

    public static function getCategories()
    {
        return [
            'operasional' => 'Operasional',
            'pemasaran' => 'Pemasaran',
            'gaji' => 'Gaji Karyawan',
            'investasi' => 'Investasi',
            'pajak' => 'Pajak',
            'lainnya' => 'Lainnya'
        ];
    }

    // Accessor untuk remaining amount
    public function getRemainingAmountAttribute()
    {
        return $this->allocated_amount - $this->used_amount;
    }

    // Accessor untuk usage percentage
    public function getUsagePercentageAttribute()
    {
        if ($this->allocated_amount == 0) return 0;
        return ($this->used_amount / $this->allocated_amount) * 100;
    }

    // Accessor untuk formatted amounts
    public function getAllocatedAmountFormattedAttribute()
    {
        return 'Rp ' . number_format($this->allocated_amount, 0, ',', '.');
    }

    public function getUsedAmountFormattedAttribute()
    {
        return 'Rp ' . number_format($this->used_amount, 0, ',', '.');
    }

    public function getRemainingAmountFormattedAttribute()
    {
        return 'Rp ' . number_format($this->remaining_amount, 0, ',', '.');
    }

    // Method untuk mendapatkan warna progress bar berdasarkan persentase
    public function getProgressColorAttribute()
    {
        if ($this->usage_percentage > 80) {
            return 'red';
        } elseif ($this->usage_percentage > 60) {
            return 'yellow';
        } else {
            return 'green';
        }
    }
}
