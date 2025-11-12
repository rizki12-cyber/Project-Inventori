<?php
// app/Models/Barang.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    // 🔹 Nama tabel (opsional, default Laravel menebak dari nama model)
    protected $table = 'barang';

    // 🔹 Mass assignable
    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'kategori',
        'jumlah',
        'kondisi',
        'lokasi',
        'tanggal_pembelian',
        'tanggal_penghapusan', // kolom baru
        'spesifikasi',        // kolom baru
        'sumber_dana',        // kolom baru
        'foto',               // kolom baru
        'keterangan',
        'user_id',            // 🔹 penting untuk relasi ke user
    ];

    // 🔹 Casting
    protected $casts = [
        'tanggal_pembelian' => 'date',
        'tanggal_penghapusan' => 'date', // kolom baru
    ];

    // 🔹 Relasi ke Transaksi (1 barang bisa punya banyak transaksi)
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }

    // 🔹 Relasi ke User (barang dimiliki siapa)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
