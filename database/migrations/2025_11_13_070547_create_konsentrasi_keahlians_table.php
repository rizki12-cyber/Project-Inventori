<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('konsentrasi_keahlians', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('program_keahlian_id');
            $table->string('nama_konsentrasi');
            $table->timestamps();

            $table->foreign('program_keahlian_id')->references('id')->on('program_keahlians')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('konsentrasi_keahlians');
    }
};
