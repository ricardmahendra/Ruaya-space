<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_menu',
        'nama_menu',
        'harga',
        'deskripsi',
        'gambar',
        'is_available',
    ];

    protected $casts = [
        'harga' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    public function recipes()
    {
        return $this->hasMany(MenuRecipe::class);
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }

    public function getAvailableQuantityAttribute()
    {
        if ($this->recipes->isEmpty()) {
            return 0;
        }

        $available = null;

        foreach ($this->recipes as $recipe) {
            if (! $recipe->barang) {
                return 0;
            }

            if ($recipe->qty <= 0) {
                continue;
            }

            $possible = floor($recipe->barang->stok / $recipe->qty);
            $available = is_null($available) ? $possible : min($available, $possible);
        }

        return $available ?? 0;
    }

    public function getAvailabilityLabelAttribute()
    {
        return $this->is_available ? ($this->available_quantity > 0 ? 'Tersedia' : 'Habis') : 'Tidak Aktif';
    }
}
