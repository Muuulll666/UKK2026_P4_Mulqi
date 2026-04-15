<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Buku;

class BukuController extends Controller
{
    public function index()
    {
        $search = request('search');
        $buku = Buku::with(['rak', 'penerbitRelasi', 'pengarangRelasi'])
            ->when($search, fn($q) => $q->where('judul', 'like', "%{$search}%")
                ->orWhere('penulis', 'like', "%{$search}%"))
            ->orderBy('judul')
            ->paginate(12);

        return view('anggota.buku.index', compact('buku', 'search'));
    }

    public function show($id)
    {
        $buku = Buku::with(['rak', 'penerbitRelasi', 'pengarangRelasi'])->findOrFail($id);
        return view('anggota.buku.show', compact('buku'));
    }
}
