<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Rak;
use App\Models\Penerbit;
use App\Models\Pengarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index()
    {
        $buku      = Buku::with(['rak', 'penerbitRelasi', 'pengarangRelasi'])->orderBy('judul')->get();
        $rak       = Rak::orderBy('nama_rak')->get();
        $penerbit  = Penerbit::orderBy('nama')->get();
        $pengarang = Pengarang::orderBy('nama')->get();
        return view('admin.buku.index', compact('buku', 'rak', 'penerbit', 'pengarang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul'        => 'required|string|max:255',
            'penulis'      => 'nullable|string|max:255',
            'penerbit'     => 'nullable|string|max:255',
            'tahun'        => 'required|integer|min:1900|max:' . date('Y'),
            'stok'         => 'required|integer|min:0',
            'rak_id'       => 'nullable|exists:rak,id',
            'penerbit_id'  => 'nullable|exists:penerbit,id',
            'pengarang_id' => 'nullable|exists:pengarang,id',
            'foto'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'judul.required' => 'Judul wajib diisi.',
            'tahun.required' => 'Tahun wajib diisi.',
            'stok.required'  => 'Stok wajib diisi.',
            'foto.image'     => 'File harus berupa gambar.',
            'foto.max'       => 'Ukuran foto maksimal 2MB.',
        ]);

        $data = $request->only('judul', 'penulis', 'penerbit', 'tahun', 'stok', 'rak_id', 'pengarang', 'penerbit_id', 'pengarang_id');

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('buku', 'public');
        }

        Buku::create($data);
        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function update(Request $request, string $id)
    {
        $buku = Buku::findOrFail($id);

        $request->validate([
            'judul'        => 'required|string|max:255',
            'penulis'      => 'nullable|string|max:255',
            'penerbit'     => 'nullable|string|max:255',
            'tahun'        => 'required|integer|min:1900|max:' . date('Y'),
            'stok'         => 'required|integer|min:0',
            'rak_id'       => 'nullable|exists:rak,id',
            'penerbit_id'  => 'nullable|exists:penerbit,id',
            'pengarang_id' => 'nullable|exists:pengarang,id',
            'foto'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'judul.required' => 'Judul wajib diisi.',
            'tahun.required' => 'Tahun wajib diisi.',
            'stok.required'  => 'Stok wajib diisi.',
            'foto.image'     => 'File harus berupa gambar.',
            'foto.max'       => 'Ukuran foto maksimal 2MB.',
        ]);

        $data = $request->only('judul', 'penulis', 'penerbit', 'tahun', 'stok', 'rak_id', 'pengarang', 'penerbit_id', 'pengarang_id');

        if ($request->hasFile('foto')) {
            if ($buku->foto) Storage::disk('public')->delete($buku->foto);
            $data['foto'] = $request->file('foto')->store('buku', 'public');
        }

        if ($request->has('hapus_foto') && $buku->foto) {
            Storage::disk('public')->delete($buku->foto);
            $data['foto'] = null;
        }

        $buku->update($data);
        return redirect()->route('admin.buku.index')->with('success', 'Data buku berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        $buku = Buku::findOrFail($id);
        if ($buku->foto) Storage::disk('public')->delete($buku->foto);
        $buku->delete();
        return redirect()->route('admin.buku.index')->with('success', 'Buku berhasil dihapus.');
    }
}
