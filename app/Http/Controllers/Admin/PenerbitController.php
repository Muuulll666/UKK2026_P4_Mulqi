<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Penerbit;
use Illuminate\Http\Request;

class PenerbitController extends Controller
{
    public function index()
    {
        $penerbit = Penerbit::orderBy('nama')->get();
        return view('admin.penerbit.index', compact('penerbit'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'kota'     => 'nullable|string|max:255',
            'telepon'  => 'nullable|string|max:20',
        ], [
            'nama.required' => 'Nama penerbit wajib diisi.',
        ]);

        Penerbit::create($request->only('nama', 'kota', 'telepon'));

        return redirect()->route('admin.penerbit.index')
                         ->with('success', 'Penerbit berhasil ditambahkan.');
    }

    public function update(Request $request, string $id)
    {
        $penerbit = Penerbit::findOrFail($id);

        $request->validate([
            'nama'    => 'required|string|max:255',
            'kota'    => 'nullable|string|max:255',
            'telepon' => 'nullable|string|max:20',
        ], [
            'nama.required' => 'Nama penerbit wajib diisi.',
        ]);

        $penerbit->update($request->only('nama', 'kota', 'telepon'));

        return redirect()->route('admin.penerbit.index')
                         ->with('success', 'Data penerbit berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        $penerbit = Penerbit::findOrFail($id);
        $penerbit->delete();

        return redirect()->route('admin.penerbit.index')
                         ->with('success', 'Penerbit berhasil dihapus.');
    }
}
