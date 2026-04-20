<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Kategori;

class BukuController extends Controller
{
    public function index()
    {
        $search     = request('search');
        $kategoriId = request('kategori_id');

        $buku = Buku::with(['rak', 'penerbitRelasi', 'pengarangRelasi', 'kategori'])
            ->when($search, fn($q) => $q->where('judul', 'like', "%{$search}%")
                ->orWhere('penulis', 'like', "%{$search}%"))
            ->when($kategoriId, fn($q) => $q->where('kategori_id', $kategoriId))
            ->orderBy('judul')
            ->paginate(12);

        $kategoriList = Kategori::orderBy('nama')->get();

        return view('anggota.buku.index', compact('buku', 'search', 'kategoriList', 'kategoriId'));
    }

    public function show($id)
    {
        $buku = Buku::with(['rak', 'penerbitRelasi', 'pengarangRelasi', 'kategori'])->findOrFail($id);
        return view('anggota.buku.show', compact('buku'));
    }
}
