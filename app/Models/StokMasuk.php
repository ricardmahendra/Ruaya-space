<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokMasuk extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_id',
        'supplier_id',
        'jumlah',
        'sisa_stok',
        'tanggal_masuk',
        'harga_beli',
        'batch_code',
        'keterangan',
        'user_id',
    ];

    protected $casts = [
        'tanggal_masuk' => 'date',
        'harga_beli' => 'decimal:2',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function fifoHistories()
    {
        return $this->hasMany(FifoHistory::class);
    }
}
