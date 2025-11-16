<?php
// app/Models/Produk.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'deskripsi',
        'harga',
        'stok',
        'kategori',
        'satuan',
        'barcode',
        'gambar',
        'status'
    ];

    // Hapus semua casting untuk menghindari error
    // protected $casts = [];

    // Accessor untuk harga formatted
    public function getHargaFormattedAttribute()
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    // Accessor untuk status badge
    public function getStatusBadgeAttribute()
    {
        return $this->status ? 'Aktif' : 'Nonaktif';
    }

    // Accessor untuk status color
    public function getStatusColorAttribute()
    {
        return $this->status ? 'green' : 'red';
    }

    // Accessor untuk stok status
    public function getStokStatusAttribute()
    {
        if ($this->stok == 0) {
            return ['status' => 'Habis', 'color' => 'red'];
        } elseif ($this->stok < 10) {
            return ['status' => 'Sedikit', 'color' => 'yellow'];
        } else {
            return ['status' => 'Tersedia', 'color' => 'green'];
        }
    }

    // Scope untuk produk aktif
    public function scopeAktif($query)
    {
        return $query->where('status', true);
    }

    // Scope untuk produk dengan stok tersedia
    public function scopeTersedia($query)
    {
        return $query->where('stok', '>', 0)->where('status', true);
    }

    // Scope untuk pencarian
    public function scopeCari($query, $search)
    {
        return $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('kategori', 'like', "%{$search}%")
                    ->orWhere('barcode', 'like', "%{$search}%");
    }
}
