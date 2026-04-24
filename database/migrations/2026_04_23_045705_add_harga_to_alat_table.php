<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Cek dulu, kalau kolom 'harga' BELUM ada, baru buat
        if (!Schema::hasColumn('alat', 'harga')) {
            Schema::table('alat', function (Blueprint $table) {
                $table->integer('harga')->default(0)->after('stok');
            });
        }
    }

    public function down()
    {
        if (Schema::hasColumn('alat', 'harga')) {
            Schema::table('alat', function (Blueprint $table) {
                $table->dropColumn('harga');
            });
        }
    }
};
