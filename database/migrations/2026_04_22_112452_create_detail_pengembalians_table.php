<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_pengembalians', function (Blueprint $table) {
            $table->id();

            // relasi pengembalian
            $table->foreignId('pengembalian_id')
                ->constrained('pengembalian')
                ->cascadeOnDelete();

            $table->foreignId('alat_id')
                ->constrained('alat')
                ->cascadeOnDelete();

            $table->string('kondisi')->nullable();
            $table->decimal('denda', 12, 2)->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pengembalians');
    }
};
