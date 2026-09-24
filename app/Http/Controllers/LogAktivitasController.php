<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;

class LogAktivitasController extends Controller
{
        public function index()
        {
            // Mengambil data log secara polos menggunakan perintah all() tanpa mengurutkan waktu
            $logs = LogAktivitas::orderBy('id_log', 'desc')->get();
            
            return view('log.index', compact('logs'));
        }
}