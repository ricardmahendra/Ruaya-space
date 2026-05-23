<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_barang')->unique();
            $table->string('nama_barang');
            $table->foreignId('kategori_id')->constrained('kategoris')->cascadeOnDelete();
            $table->string('satuan');
            $table->integer('stok')->default(0);
            $table->integer('stok_minimal')->default(0);
            $table->decimal('harga_beli', 12, 2)->default(0);
            $table->date('tanggal_expired')->nullable();
            $table->string('lokasi_rak')->nullable();
            $table->string('gambar')->nullable();
            $table->integer('average_usage')->default(0);
            $table->integer('lead_time')->default(1);
            $table->integer('safety_stock')->default(0);
            $table->integer('reorder_point')->default(0);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
