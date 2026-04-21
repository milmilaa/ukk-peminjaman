<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id();

            // ================= USER =================
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            // ================= ALAT =================
            $table->foreignId('alat_id')
                ->constrained('alats')
                ->onDelete('cascade');

            // ================= JUMLAH (INI YANG KAMU LUPA) =================
            $table->integer('jumlah')->default(1);

            // ================= TANGGAL =================
            $table->date('tanggal_pinjam');
            $table->date('tanggal_kembali')->nullable();

            // ================= STATUS =================
            $table->enum('status', [
                'menunggu',
                'disetujui',
                'ditolak',
                'dikembalikan'
            ])->default('menunggu');

            $table->timestamps();

            // ================= INDEX (BIAR CEPAT QUERY) =================
            $table->index('status');
            $table->index('user_id');
            $table->index('alat_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};
