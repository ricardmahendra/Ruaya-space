<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cash_in_outs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cashier_shift_id')->constrained('cashier_shifts')->cascadeOnDelete();
            $table->enum('tipe', ['in', 'out']);
            $table->decimal('nominal', 12, 2);
            $table->string('keterangan');
            $table->text('catatan')->nullable();
            $table->timestamp('tanggal')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cash_in_outs');
    }
};
