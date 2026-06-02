<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_transaksi')->unique();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('total', 12, 2)->default(0);
            $table->decimal('bayar', 12, 2)->default(0);
            $table->decimal('kembalian', 12, 2)->default(0);
            $table->enum('metode_bayar', ['tunai', 'transfer', 'kartu'])->default('tunai');
            $table->text('catatan')->nullable();
            $table->timestamp('tanggal_transaksi')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
