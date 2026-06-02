<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cashier_shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->decimal('kas_awal', 12, 2)->default(0);
            $table->decimal('total_penjualan', 12, 2)->default(0);
            $table->decimal('total_setor', 12, 2)->default(0);
            $table->decimal('total_tarik', 12, 2)->default(0);
            $table->decimal('kas_akhir', 12, 2)->default(0);
            $table->timestamp('opened_at')->useCurrent();
            $table->timestamp('closed_at')->nullable();
            $table->text('catatan_pembukaan')->nullable();
            $table->text('catatan_penutupan')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cashier_shifts');
    }
};
