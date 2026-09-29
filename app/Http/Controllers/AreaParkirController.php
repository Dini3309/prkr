<?php

namespace App\Http\Controllers;

use App\Models\AreaParkir;
use Illuminate\Http\Request;

class AreaParkirController extends Controller
{
    
    public function index()
    {
        $areaParkir = AreaParkir::all();

        return view('area.index', compact('areaParkir'));
    }

    public function create()
    {
        return view('area.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_area' => 'required|string|max:50',
            'kapasitas' => 'required|numeric|min:1',
        ]);

        AreaParkir::create($request->only(['nama_area', 'kapasitas']));

        return redirect()->route('area.index')->with('sukses', 'Area parkir berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $area = AreaParkir::findOrFail($id);
        return view('area.edit', compact('area'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_area' => 'required|string|max:50',
            'kapasitas' => 'required|numeric|min:1',
        ]);

        $area = AreaParkir::findOrFail($id);
        $area->update($request->only(['nama_area', 'kapasitas']));

        return redirect()->route('area.index')->with('sukses', 'Data area berhasil diperbarui.');
    }

    public function destroy($id)
    {
        AreaParkir::findOrFail($id)->delete();
        return redirect()->route('area.index')->with('sukses', 'Area parkir berhasil dihapus.');
    }
}