<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function petugas()
    {
        return view('petugas.dashboard');
    }

    public function owner()
    {
        return view('owner.dashboard');
    }
}