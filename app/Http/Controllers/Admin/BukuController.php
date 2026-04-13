<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Rak;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::with('rak')->orderBy('judul')->get();
        $rak  = Rak::orderBy('nama_rak')->get();
        return view('admin.buku.index', compact('buku', 'rak'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'    => 'required|string|max:255',
            'penulis'  => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun'    => 'required|integer|min:1900|max:' . date('Y'),
            'stok'     => 'required|integer|min:0',
            'rak_id'   => 'nullable|exists:rak,id',
        ], [
            'judul.required'    => 'Judul wajib diisi.',
            'penulis.required'  => 'Penulis wajib diisi.',
            'penerbit.required' => 'Penerbit wajib diisi.',
            'tahun.required'    => 'Tahun wajib diisi.',
            'stok.required'     => 'Stok wajib diisi.',
        ]);

        Buku::create($request->only('judul', 'penulis', 'penerbit', 'tahun', 'stok', 'rak_id', 'pengarang'));
        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function update(Request $request, string $id)
    {
        $buku = Buku::findOrFail($id);

        $request->validate([
            'judul'    => 'required|string|max:255',
            'penulis'  => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'tahun'    => 'required|integer|min:1900|max:' . date('Y'),
            'stok'     => 'required|integer|min:0',
            'rak_id'   => 'nullable|exists:rak,id',
        ], [
            'judul.required'    => 'Judul wajib diisi.',
            'penulis.required'  => 'Penulis wajib diisi.',
            'penerbit.required' => 'Penerbit wajib diisi.',
            'tahun.required'    => 'Tahun wajib diisi.',
            'stok.required'     => 'Stok wajib diisi.',
        ]);

        $buku->update($request->only('judul', 'penulis', 'penerbit', 'tahun', 'stok', 'rak_id', 'pengarang'));
        return redirect()->route('admin.buku.index')->with('success', 'Data buku berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        $buku = Buku::findOrFail($id);
        $buku->delete();
        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil dihapus.');
    }
}
