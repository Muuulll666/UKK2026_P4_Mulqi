<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rak;
use Illuminate\Http\Request;

class RakController extends Controller
{
    public function index()
    {
        $rak = Rak::withCount('buku')->orderBy('nama_rak')->get();
        return view('admin.rak.index', compact('rak'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_rak' => 'required|string|max:255',
            'lokasi'   => 'nullable|string|max:255',
        ], [
            'nama_rak.required' => 'Nama rak wajib diisi.',
        ]);

        Rak::create($request->only('nama_rak', 'lokasi'));
        return redirect()->route('admin.rak.index')->with('success', 'Rak berhasil ditambahkan.');
    }

    public function update(Request $request, string $id)
    {
        $rak = Rak::findOrFail($id);

        $request->validate([
            'nama_rak' => 'required|string|max:255',
            'lokasi'   => 'nullable|string|max:255',
        ], [
            'nama_rak.required' => 'Nama rak wajib diisi.',
        ]);

        $rak->update($request->only('nama_rak', 'lokasi'));
        return redirect()->route('admin.rak.index')->with('success', 'Rak berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        $rak = Rak::findOrFail($id);
        if ($rak->buku()->count() > 0) {
            return redirect()->route('admin.rak.index')->with('error', 'Rak tidak bisa dihapus karena masih memiliki buku.');
        }
        $rak->delete();
        return redirect()->route('admin.rak.index')->with('success', 'Rak berhasil dihapus.');
    }
}
