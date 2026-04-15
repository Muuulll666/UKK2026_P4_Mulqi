<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'buku_ids'   => 'required|array|min:1|max:3',
            'buku_ids.*' => 'exists:buku,id',
        ], [
            'buku_ids.required' => 'Pilih minimal 1 buku.',
            'buku_ids.max'      => 'Maksimal 3 buku sekaligus.',
        ]);

        $userId = Auth::id();

        // Cek peminjaman aktif (menunggu atau dipinjam)
        $aktif = Transaksi::where('user_id', $userId)
            ->whereIn('status', ['menunggu', 'dipinjam'])
            ->count();

        if ($aktif > 0) {
            return back()->with('error', 'Kamu masih memiliki peminjaman yang belum selesai. Selesaikan dulu sebelum meminjam lagi.');
        }

        // Cek stok semua buku
        $bukuList = Buku::whereIn('id', $request->buku_ids)->get();
        foreach ($bukuList as $buku) {
            if ($buku->stok < 1) {
                return back()->with('error', "Buku \"{$buku->judul}\" stoknya habis.");
            }
        }

        // Buat transaksi
        $transaksi = Transaksi::create([
            'user_id'         => $userId,
            'tanggal_pinjam'  => Carbon::today(),
            'tanggal_kembali' => Carbon::today()->addDays(7),
            'status'          => 'menunggu',
            'denda'           => 0,
        ]);

        foreach ($request->buku_ids as $bukuId) {
            DetailTransaksi::create([
                'transaksi_id' => $transaksi->id,
                'buku_id'      => $bukuId,
                'jumlah'       => 1,
            ]);
        }

        return redirect()->route('anggota.history')
            ->with('success', 'Permintaan peminjaman berhasil dikirim. Menunggu persetujuan petugas.');
    }

    public function history()
    {
        $transaksi = Transaksi::with(['detailTransaksi.buku'])
            ->where('user_id', Auth::id())
            ->orderByDesc('id')
            ->paginate(10);

        return view('anggota.history', compact('transaksi'));
    }

    public function kembalikan($id)
    {
        $transaksi = Transaksi::where('user_id', Auth::id())
            ->where('id', $id)
            ->where('status', 'dipinjam')
            ->firstOrFail();

        // Hitung denda jika terlambat
        $today = Carbon::today();
        $jatuhTempo = Carbon::parse($transaksi->tanggal_kembali);
        $denda = 0;
        if ($today->gt($jatuhTempo)) {
            $denda = $today->diffInDays($jatuhTempo) * 1000;
        }

        $transaksi->update([
            'status' => 'dikembalikan',
            'denda'  => $denda,
        ]);

        // Kembalikan stok
        foreach ($transaksi->detailTransaksi as $detail) {
            $detail->buku->increment('stok');
        }

        $msg = $denda > 0
            ? "Buku berhasil dikembalikan. Denda: Rp " . number_format($denda, 0, ',', '.')
            : 'Buku berhasil dikembalikan. Terima kasih!';

        return back()->with('success', $msg);
    }
}
