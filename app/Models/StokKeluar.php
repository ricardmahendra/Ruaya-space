<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokKeluar extends Model
{
    use HasFactory;

    protected $fillable = [
        'barang_id',
        'jumlah',
        'tanggal_keluar',
        'tujuan_penggunaan',
        'keterangan',
        'user_id',
    ];

    protected $casts = [
        'tanggal_keluar' => 'date',
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
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
