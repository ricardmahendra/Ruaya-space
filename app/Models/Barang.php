<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori_id',
        'satuan',
        'stok',
        'stok_minimal',
        'harga_beli',
        'tanggal_expired',
        'lokasi_rak',
        'gambar',
        'average_usage',
        'lead_time',
        'safety_stock',
        'reorder_point',
        'deskripsi',
    ];

    protected $casts = [
        'tanggal_expired' => 'date',
        'harga_beli' => 'decimal:2',
        'average_usage' => 'integer',
        'lead_time' => 'integer',
        'safety_stock' => 'integer',
        'reorder_point' => 'integer',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function stokMasuks()
    {
        return $this->hasMany(StokMasuk::class);
    }

    public function stokKeluars()
    {
        return $this->hasMany(StokKeluar::class);
    }

    public function fifoHistories()
    {
        return $this->hasMany(FifoHistory::class);
    }

    public function getStatusStokAttribute()
    {
        if ($this->stok <= 0) {
            return 'habis';
        }

        if ($this->stok <= $this->reorder_point) {
            return 'menipis';
        }

        return 'aman';
    }

    public function getIsReorderPointAttribute()
    {
        return $this->stok <= $this->reorder_point;
    }

    public function hitungReorderPoint(): int
    {
        return ($this->average_usage * $this->lead_time) + $this->safety_stock;
    }

    protected static function booted(): void
    {
        static::saving(function (Barang $barang) {
            $barang->reorder_point = $barang->hitungReorderPoint();
        });
    }
}
