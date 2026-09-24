<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // Ambil semua data dari tb_user
        $users = DB::table('tb_user')
            ->orderBy('id_user', 'asc')
            ->get();

        return view('admin.pengguna.index', compact('users'));
    }

    public function create()
    {
        return view('admin.pengguna.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'username' => 'required|unique:tb_user,username',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,petugas,owner',
            'status_aktif' => 'required|in:0,1',
        ]);

        DB::table('tb_user')->insert([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'status_aktif' => $request->status_aktif,
        ]);

        return redirect()
            ->route('pengguna.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $user = DB::table('tb_user')
            ->where('id_user', $id)
            ->first();

        return view('admin.pengguna.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $data = [
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'role' => $request->role,
            'status_aktif' => $request->status_aktif,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        DB::table('tb_user')
            ->where('id_user', $id)
            ->update($data);

        return redirect()
            ->route('pengguna.index')
            ->with('success', 'Pengguna berhasil diperbarui.');
    }

    public function destroy($id)
    {
        DB::table('tb_user')
            ->where('id_user', $id)
            ->delete();

        return redirect()
            ->route('pengguna.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}