<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('detail_peminjaman', function (Blueprint $table) {
            $table->id();

            $table->foreignId('peminjaman_id')
                ->constrained('peminjaman')
                ->onDelete('cascade');

            $table->foreignId('alat_id')
                ->constrained('alat')
                ->onDelete('cascade');

            $table->integer('qty');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('detail_peminjaman');
    }
};
