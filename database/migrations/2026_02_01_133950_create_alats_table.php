<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alats', function (Blueprint $table) {
    $table->id();
    $table->string('nama_alat');
    $table->unsignedBigInteger('kategori_id');
    $table->integer('jumlah')->default(0);
    $table->string('gambar')->nullable();
    $table->timestamps();

    $table->foreign('kategori_id')
          ->references('id')
          ->on('kategoris')
          ->onDelete('cascade');
});

    }

    public function down(): void
    {
        Schema::dropIfExists('alats');
    }
};
