<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashierShift extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kas_awal',
        'total_penjualan',
        'total_setor',
        'total_tarik',
        'kas_akhir',
        'opened_at',
        'closed_at',
        'catatan_pembukaan',
        'catatan_penutupan',
    ];

    protected $casts = [
        'kas_awal' => 'decimal:2',
        'total_penjualan' => 'decimal:2',
        'total_setor' => 'decimal:2',
        'total_tarik' => 'decimal:2',
        'kas_akhir' => 'decimal:2',
        'opened_at' => 'datetime',
        'closed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
