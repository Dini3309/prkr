<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parkir extends Model
{
    protected $table = 'tb_parkir';
    protected $fillable = ['plat_nomor', 'tarif_id', 'petugas_id', 'jam_masuk', 'jam_keluar', 'biaya', 'status'];

    public function tarif()
    {
        return $this->belongsTo(Tarif::class, 'tarif_id');
    }

    public function petugas()
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }
}