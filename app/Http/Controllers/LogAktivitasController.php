<?php

namespace App\Http\Controllers;

use App\Models\LogAktivitas;
use Illuminate\Support\Facades\DB;

class LogAktivitasController extends Controller
{
    public function index()
    {
        // Ambil semua log aktivitas
        $logAktivitas = LogAktivitas::orderBy('id_log', 'desc')->get();

        // Total seluruh aktivitas
        $totalLog = LogAktivitas::count();

        // Aktivitas hari ini
        $logHariIni = LogAktivitas::whereDate(
            'waktu_aktivitas',
            today()
        )->count();

        // Jumlah pengguna yang melakukan aktivitas
        $totalUser = LogAktivitas::distinct('id_user')->count('id_user');

        return view('log.index', compact(
            'logAktivitas',
            'totalLog',
            'logHariIni',
            'totalUser'
        ));
    }
}