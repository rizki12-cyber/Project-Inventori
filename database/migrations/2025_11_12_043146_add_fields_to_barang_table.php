<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->string('foto')->nullable()->after('lokasi'); // tambahkan foto
            $table->text('spesifikasi')->nullable()->after('foto');
            $table->string('sumber_dana')->nullable()->after('spesifikasi');
            $table->date('tanggal_penghapusan')->nullable()->after('tanggal_pembelian');
        });
    }

    public function down(): void
    {
        Schema::table('barang', function (Blueprint $table) {
            $table->dropColumn(['foto', 'spesifikasi', 'sumber_dana', 'tanggal_penghapusan']);
        });
    }
};
