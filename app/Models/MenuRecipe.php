<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuRecipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'menu_id',
        'barang_id',
        'qty',
    ];

    protected $casts = [
        'qty' => 'decimal:2',
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
}
