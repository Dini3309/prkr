<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;

class KendaraanController extends Controller
{
    public function index()
    {
        $kendaraan = Kendaraan::all();
        return view('kendaraan.index', compact('kendaraan'));
    }

    public function create()
    {
        return view('kendaraan.create');
    }

    public function store(Request $request)
    {
        // 1. Validasi input form
        $request->validate([
            'no_plat'         => 'required|string|max:20',
            'jenis_kendaraan' => 'required|string|max:50',
        ]);

        // 2. Ambil data ID user yang sedang login dari database berdasarkan session username Anda
        $username = session('username');
        $user = \DB::table('tb_user')->where('username', $username)->first();
        
        // Ambil ID-nya, jika database kosong / tidak ditemukan, gunakan ID pertama yang ada di tb_user
        $idUserAktif = $user ? ($user->id_user ?? $user->id) : \DB::table('tb_user')->value('id_user');

        // 3. Simpan ke database dengan ID user yang valid hasil pelacakan di atas
        Kendaraan::create([
            'plat_nomor'      => $request->no_plat,
            'jenis_kendaraan' => $request->jenis_kendaraan,
            'id_user'         => $idUserAktif,
        ]);

        return redirect()->route('kendaraan.index')->with('sukses', 'Data kendaraan berhasil ditambahkan.');
    }



    public function edit($id)
    {
        // Mengambil data kendaraan yang mau diedit berdasarkan ID-nya
        $kendaraan = Kendaraan::findOrFail($id);
        return view('kendaraan.edit', compact('kendaraan'));
    }

    public function update(Request $request, $id)
    {
        $kendaraan = Kendaraan::findOrFail($id);

        // Validasi data perubahan
        $request->validate([
            'no_plat'         => 'required|string|max:20',
            'jenis_kendaraan' => 'required|string|max:50',
        ]);

        // Update data di database
        $kendaraan->update([
            'plat_nomor'      => $request->no_plat,
            'jenis_kendaraan' => $request->jenis_kendaraan,
        ]);

        return redirect()->route('kendaraan.index')->with('sukses', 'Data kendaraan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        // Fungsi hapus data kendaraan
        $kendaraan = Kendaraan::findOrFail($id);
        $kendaraan->delete();

        return redirect()->route('kendaraan.index')->with('sukses', 'Data kendaraan berhasil dihapus.');
    }
}
