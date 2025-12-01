<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $table = 'transaction';

    protected $fillable = [
        'judul',
        'jumlah',
        'tipe',
        'kategori',
        'prioritas',
        'tanggal',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}