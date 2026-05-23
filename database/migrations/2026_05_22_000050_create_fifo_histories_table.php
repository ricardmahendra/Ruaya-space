<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fifo_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stok_masuk_id')->constrained('stok_masuks')->cascadeOnDelete();
            $table->foreignId('stok_keluar_id')->constrained('stok_keluars')->cascadeOnDelete();
            $table->foreignId('barang_id')->constrained('barangs')->cascadeOnDelete();
            $table->integer('jumlah_diambil')->unsigned();
            $table->date('tanggal_pengambilan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fifo_histories');
    }
};
