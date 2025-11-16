<?php
// app/Models/Investment.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'initial_amount',
        'current_value',
        'return_amount',
        'return_percentage',
        'start_date',
        'risk_level',
        'description',
        'symbol',
        'quantity',
        'average_price',
        'status'
    ];

    protected $casts = [
        'initial_amount' => 'float',
        'current_value' => 'float',
        'return_amount' => 'float',
        'return_percentage' => 'float',
        'average_price' => 'float',
        'start_date' => 'date'
    ];

    public static function getInvestmentTypes()
    {
        return [
            'saham' => 'Saham',
            'reksadana' => 'Reksadana',
            'deposito' => 'Deposito',
            'obligasi' => 'Obligasi',
            'emas' => 'Emas',
            'property' => 'Property',
            'crypto' => 'Cryptocurrency',
            'lainnya' => 'Lainnya'
        ];
    }

    public static function getRiskLevels()
    {
        return [
            'low' => 'Rendah',
            'medium' => 'Sedang',
            'high' => 'Tinggi'
        ];
    }

    public static function getStatuses()
    {
        return [
            'active' => 'Aktif',
            'sold' => 'Terjual',
            'matured' => 'Jatuh Tempo'
        ];
    }

    // Accessor untuk formatted amounts
    public function getInitialAmountFormattedAttribute()
    {
        return 'Rp ' . number_format($this->initial_amount, 0, ',', '.');
    }

    public function getCurrentValueFormattedAttribute()
    {
        return 'Rp ' . number_format($this->current_value, 0, ',', '.');
    }

    public function getReturnAmountFormattedAttribute()
    {
        return 'Rp ' . number_format($this->return_amount, 0, ',', '.');
    }

    public function getAveragePriceFormattedAttribute()
    {
        return $this->average_price ? 'Rp ' . number_format($this->average_price, 0, ',', '.') : '-';
    }

    // Accessor untuk duration
    public function getDurationAttribute()
    {
        return now()->diffInMonths($this->start_date);
    }

    // Accessor untuk risk level badge color
    public function getRiskLevelBadgeAttribute()
    {
        return [
            'low' => 'green',
            'medium' => 'yellow',
            'high' => 'red'
        ][$this->risk_level] ?? 'gray';
    }

    // Accessor untuk status badge color
    public function getStatusBadgeAttribute()
    {
        return [
            'active' => 'blue',
            'sold' => 'green',
            'matured' => 'purple'
        ][$this->status] ?? 'gray';
    }

    // Accessor untuk return color
    public function getReturnColorAttribute()
    {
        return $this->return_amount >= 0 ? 'green' : 'red';
    }

    // Method untuk calculate return
    public function calculateReturn()
    {
        $this->return_amount = $this->current_value - $this->initial_amount;
        $this->return_percentage = $this->initial_amount > 0 ? ($this->return_amount / $this->initial_amount) * 100 : 0;
    }

    // Scope untuk active investments
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Scope by type
    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Scope by risk level
    public function scopeRiskLevel($query, $riskLevel)
    {
        return $query->where('risk_level', $riskLevel);
    }
}
