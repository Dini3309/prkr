<?php

namespace App\Http\Controllers;

use App\Models\Parkir;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Parkir::with('tarif')->whereNotNull('jam_keluar');

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_selesai')) {
            $query->whereBetween('jam_keluar', [$request->tanggal_mulai . ' 00:00:00', $request->tanggal_selesai . ' 23:59:59']);
        }

        $laporan = $query->latest()->get();
        $totalPendapatan = $laporan->sum('total_bayar');

        return view('laporan.index', compact('laporan', 'totalPendapatan'));
    }
}