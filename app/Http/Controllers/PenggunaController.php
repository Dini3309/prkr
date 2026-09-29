<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PenggunaController extends Controller
{
    public function index()
    {
        $pengguna = DB::table('tb_user')
            ->orderBy('id_user', 'desc')
            ->get();

        $totalUser = DB::table('tb_user')->count();
        $totalAdmin = DB::table('tb_user')->where('role', 'admin')->count();
        $totalPetugas = DB::table('tb_user')->where('role', 'petugas')->count();
        $totalOwner = DB::table('tb_user')->where('role', 'owner')->count();

        return view('pengguna.index', compact(
            'pengguna',
            'totalUser',
            'totalAdmin',
            'totalPetugas',
            'totalOwner'
        ));
    }

    public function create()
    {
        return view('pengguna.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'username' => 'required|unique:tb_user,username',
            'password' => 'required|min:3',
            'role' => 'required|in:admin,petugas,owner',
            'email' => 'nullable|email',
        ]);

        DB::table('tb_user')->insert([
            'nama_lengkap'         => $request->nama,
            'username'     => $request->username,
            'password'     => Hash::make($request->password),
            'role'         => $request->role,
            'status_aktif' => 1,
        ]);

        return redirect('/pengguna')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit($id_user)
    {
        $pengguna = DB::table('tb_user')
            ->where('id_user', $id_user)
            ->first();

        if (!$pengguna) {
            return redirect('/pengguna')
                ->with('error', 'Data pengguna tidak ditemukan.');
        }

        return view('admin.pengguna.edit', compact('pengguna'));
    }

    public function update(Request $request, $id_user)
    {
        $request->validate([
            'nama' => 'required',
            'username' => 'required',
            'role' => 'required|in:admin,petugas,owner',
            'email' => 'nullable|email',
        ]);

        $data = [
            'nama' => $request->nama,
            'username' => $request->username,
            'role' => $request->role,
            'email' => $request->email,
            'status_aktif' => $request->status_aktif ?? 1,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        DB::table('tb_user')
            ->where('id_user', $id_user)
            ->update($data);

        return redirect('/pengguna')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy($id_user)
    {
        DB::table('tb_user')
            ->where('id_user', $id_user)
            ->delete();

        return redirect('/pengguna')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}