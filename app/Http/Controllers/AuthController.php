<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // Menampilkan halaman login
    public function showLogin()
    {
        return view('login');
    }


    // Proses login
    public function login(Request $request)
    {
        // Validasi
        $request->validate([
            'username' => 'required',
            'password' => 'required',
            'role'     => 'required',
        ]);


        // Cari username
        $user = DB::table('tb_user')
            ->where('username', $request->username)
            ->first();


        // Username tidak ditemukan
        if (!$user) {
            return back()
                ->withErrors([
                    'login' => 'Username tidak ditemukan.'
                ])
                ->withInput();
        }


        // Cek password
        $passwordBenar = false;

        // Kalau password di database sudah HASH
        if (Hash::check($request->password, $user->password)) {
            $passwordBenar = true;
        }

        // Untuk database lama yang password-nya masih teks biasa
        if ($request->password === $user->password) {
            $passwordBenar = true;
        }


        if (!$passwordBenar) {
            return back()
                ->withErrors([
                    'login' => 'Password salah.'
                ])
                ->withInput();
        }


        // Cek role
        if ($user->role !== $request->role) {
            return back()
                ->withErrors([
                    'login' => 'Role tidak sesuai dengan akun.'
                ])
                ->withInput();
        }


        // Cek status aktif
        if (isset($user->status_aktif) && $user->status_aktif != 1) {
            return back()
                ->withErrors([
                    'login' => 'Akun sedang tidak aktif.'
                ])
                ->withInput();
        }


        // Simpan session
        Session::put('user_id', $user->id_user);
        Session::put('username', $user->username);
        Session::put('user_role', $user->role);


        // Login berhasil
        if ($user->role === 'admin') {

            return redirect()
                ->route('dashboard')
                ->with('success', 'Login sebagai Admin berhasil.');
        }


        if ($user->role === 'petugas') {

            return redirect()
                ->route('petugas.dashboard')
                ->with('success', 'Login sebagai Petugas berhasil.');
        }


        if ($user->role === 'owner') {

            return redirect()
                ->route('owner.dashboard')
                ->with('success', 'Login sebagai Owner berhasil.');
        }


        return back()
            ->withErrors([
                'login' => 'Role akun tidak dikenali.'
            ]);
    }


    // Logout
    public function logout()
    {
        Session::flush();

        return redirect()
            ->route('login')
            ->with('success', 'Berhasil logout.');
    }
}