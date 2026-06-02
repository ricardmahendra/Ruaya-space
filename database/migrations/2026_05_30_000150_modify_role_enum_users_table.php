<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Update enum values for role column
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'kasir') NOT NULL DEFAULT 'kasir'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY role ENUM('admin', 'staff') NOT NULL DEFAULT 'staff'");
    }
};
