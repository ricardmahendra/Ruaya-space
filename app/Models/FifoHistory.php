<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FifoHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'stok_masuk_id',
        'stok_keluar_id',
        'barang_id',
        'jumlah_diambil',
        'tanggal_pengambilan',
    ];

    protected $casts = [
        'tanggal_pengambilan' => 'date',
    ];

    public function stokMasuk()
    {
        return $this->belongsTo(StokMasuk::class);
    }

    public function stokKeluar()
    {
        return $this->belongsTo(StokKeluar::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
