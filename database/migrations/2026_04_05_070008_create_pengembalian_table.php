<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengembalian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peminjaman_id')->constrained('peminjaman')->cascadeOnDelete();
            $table->date('tanggal_kembali');
            $table->text('kondisi')->nullable();

            // ================= TAMBAHAN DENDA CASH OFFLINE =================
            $table->decimal('denda', 12, 2)->nullable()->default(0);
            $table->enum('status_denda', ['belum_bayar', 'lunas'])->nullable()->default('belum_bayar');
            $table->string('metode_bayar')->nullable()->default('cash');
            $table->date('tanggal_bayar')->nullable();
            // ===============================================================

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengembalian');
    }
};
