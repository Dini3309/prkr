<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard');
    }

    public function petugas()
    {
        return view('dashboard');
    }

    public function owner()
    {
        return view('dashboard');
    }
}