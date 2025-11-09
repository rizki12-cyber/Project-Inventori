<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->string('password');
    $table->enum('role', ['admin', 'wakasek', 'kabeng'])->default('kabeng');
    $table->string('jurusan')->nullable(); // hanya diisi oleh Kabeng
    $table->timestamps();
});

    }

    /**
     * Hapus tabel jika dibatalkan.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
