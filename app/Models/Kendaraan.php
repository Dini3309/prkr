<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    // Nama tabel database Anda
    protected $table = 'tb_kendaraan'; 

    // WAJIB TAMBAHKAN BARIS INI:
    protected $fillable = [
        'plat_nomor',
        'jenis_kendaraan',
        'id_user',
        'merk',
        'nama_pemilik'
    ];
}
