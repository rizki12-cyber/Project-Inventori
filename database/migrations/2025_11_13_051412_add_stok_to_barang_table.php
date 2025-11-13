<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('barang', function (Blueprint $table) {
        $table->integer('stok')->default(0)->after('jumlah'); // sesuaikan 'harga' dengan kolom terakhir kamu
    });
}

public function down()
{
    Schema::table('barang', function (Blueprint $table) {
        $table->dropColumn('stok');
    });
}

};
