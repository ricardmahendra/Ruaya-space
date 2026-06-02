<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'nomor_transaksi',
        'user_id',
        'total',
        'bayar',
        'kembalian',
        'metode_bayar',
        'catatan',
        'tanggal_transaksi',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'bayar' => 'decimal:2',
        'kembalian' => 'decimal:2',
        'tanggal_transaksi' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }
}
