<?php

namespace App\Http\Controllers;

use App\Models\Parkir; // Pastikan nama model database parkir Anda sudah sesuai
use Illuminate\Http\Request;
use App\Models\Tarif;

class ParkirController extends Controller
{
    public function index()
{
    $transaksi = Parkir::with('tarif')
        ->orderBy('id_parkir', 'desc')
        ->get();

    $totalTransaksi = Parkir::count();

    $totalMasuk = Parkir::where('status', 'masuk')->count();

    $totalKeluar = Parkir::where('status', 'keluar')->count();

    return view('transaksi.index', compact(
        'transaksi',
        'totalTransaksi',
        'totalMasuk',
        'totalKeluar'
    ));
}


    public function create()
    {
        return view('parkir.create');
    }

    public function store(Request $request)
    {
        // Logika menyimpan kendaraan masuk dimasukkan di sini nanti
        return redirect()->route('parkir.index')->with('sukses', 'Kendaraan berhasil masuk.');
    }

    public function edit($id)
    {
        $parkir = Parkir::findOrFail($id);
        return view('parkir.edit', compact('parkir'));
    }

    public function update(Request $request, $id)
    {
        // Logika mencatat kendaraan keluar/pembayaran dimasukkan di sini nanti
        return redirect()->route('parkir.index')->with('sukses', 'Transaksi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $parkir = Parkir::findOrFail($id);
        $parkir->delete();

        return redirect()->route('parkir.index')->with('sukses', 'Transaksi berhasil dihapus.');
    }

    public function struk($id)
    {
        // Logika cetak struk pembayaran parkir
        $parkir = Parkir::findOrFail($id);
        return view('parkir.struk', compact('parkir'));
    }
}
