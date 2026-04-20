<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    public function index()
    {
        $filter = request('filter', 'semua');

        $query = Transaksi::with(['user', 'detailTransaksi.buku'])->orderByDesc('id');

        if ($filter !== 'semua') {
            $query->where('status', $filter);
        }

        $transaksi = $query->paginate(15)->withQueryString();

        $counts = [
            'semua'         => Transaksi::count(),
            'menunggu'      => Transaksi::where('status', 'menunggu')->count(),
            'dipinjam'      => Transaksi::where('status', 'dipinjam')->count(),
            'dikembalikan'  => Transaksi::where('status', 'dikembalikan')->count(),
            'ditolak'       => Transaksi::where('status', 'ditolak')->count(),
        ];

        return view('petugas.transaksi.index', compact('transaksi', 'filter', 'counts'));
    }

    public function show($id)
    {
        $transaksi = Transaksi::with(['user', 'detailTransaksi.buku'])->findOrFail($id);
        return view('petugas.transaksi.show', compact('transaksi'));
    }

    public function terima($id)
    {
        $transaksi = Transaksi::where('status', 'menunggu')->findOrFail($id);

        $transaksi->update(['status' => 'dipinjam']);

        // Kurangi stok
        foreach ($transaksi->detailTransaksi as $detail) {
            $detail->buku->decrement('stok');
        }

        return back()->with('success', 'Peminjaman berhasil disetujui.');
    }

    public function tolak($id)
    {
        $transaksi = Transaksi::where('status', 'menunggu')->findOrFail($id);
        $transaksi->update(['status' => 'ditolak']);

        return back()->with('success', 'Peminjaman ditolak.');
    }

    public function kembalikan($id)
    {
        $transaksi = Transaksi::where('status', 'dipinjam')->findOrFail($id);

        $today      = Carbon::today();
        $jatuhTempo = Carbon::parse($transaksi->tanggal_kembali);
        $denda      = 0;

        if ($today->gt($jatuhTempo)) {
            $denda = $today->diffInDays($jatuhTempo) * 1000;
        }

        $transaksi->update([
            'status' => 'dikembalikan',
            'denda'  => $denda,
        ]);

        foreach ($transaksi->detailTransaksi as $detail) {
            $detail->buku->increment('stok');
        }

        return back()->with('success', 'Buku telah dicatat dikembalikan.' . ($denda > 0 ? ' Denda: Rp ' . number_format($denda, 0, ',', '.') : ''));
    }

    public function lunasi($id)
    {
        $transaksi = Transaksi::where('status', 'dikembalikan')->findOrFail($id);
        $transaksi->update(['denda' => 0]);

        return back()->with('success', 'Denda berhasil dilunasi.');
    }
}
