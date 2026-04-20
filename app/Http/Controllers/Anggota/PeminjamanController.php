<?php
namespace App\Http\Controllers\Anggota;
use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeminjamanController extends Controller {
    public function store(Request $request) {
        $request->validate([
            'buku_ids'   => 'required|array|min:1|max:3',
            'buku_ids.*' => 'exists:buku,id',
            'lama_pinjam'=> 'required|integer|min:1|max:30',
        ], [
            'buku_ids.required'    => 'Pilih minimal 1 buku.',
            'buku_ids.max'         => 'Maksimal 3 buku sekaligus.',
            'lama_pinjam.required' => 'Durasi pinjam wajib diisi.',
            'lama_pinjam.min'      => 'Minimal 1 hari.',
            'lama_pinjam.max'      => 'Maksimal 30 hari.',
        ]);

        $userId = Auth::id();
        $lamaPinjam = (int) $request->lama_pinjam;

        $aktif = Transaksi::where('user_id', $userId)
            ->whereIn('status', ['menunggu', 'dipinjam'])->count();

        if ($aktif > 0) {
            return back()->with('error', 'Kamu masih memiliki peminjaman yang belum selesai. Selesaikan dulu sebelum meminjam lagi.');
        }

        $bukuList = Buku::whereIn('id', $request->buku_ids)->get();
        foreach ($bukuList as $buku) {
            if ($buku->stok < 1) {
                return back()->with('error', "Buku \"{$buku->judul}\" stoknya habis.");
            }
        }

        $transaksi = Transaksi::create([
            'user_id'         => $userId,
            'tanggal_pinjam'  => Carbon::today(),
            'tanggal_kembali' => Carbon::today()->addDays($lamaPinjam),
            'status'          => 'menunggu',
            'denda'           => 0,
            'lama_pinjam'     => $lamaPinjam,
        ]);

        foreach ($request->buku_ids as $bukuId) {
            DetailTransaksi::create(['transaksi_id' => $transaksi->id, 'buku_id' => $bukuId, 'jumlah' => 1]);
        }

        return redirect()->route('anggota.history')
            ->with('success', "Permintaan peminjaman selama {$lamaPinjam} hari berhasil dikirim. Menunggu persetujuan petugas.");
    }

    public function history() {
        $transaksi = Transaksi::with(['detailTransaksi.buku'])
            ->where('user_id', Auth::id())
            ->orderByDesc('id')
            ->paginate(10);
        return view('anggota.history', compact('transaksi'));
    }

    public function kembalikan($id) {
        $transaksi = Transaksi::where('user_id', Auth::id())
            ->where('id', $id)->where('status', 'dipinjam')->firstOrFail();

        $today = Carbon::today();
        $jatuhTempo = Carbon::parse($transaksi->tanggal_kembali);
        $denda = 0;
        if ($today->gt($jatuhTempo)) {
            $denda = $today->diffInDays($jatuhTempo) * 1000;
        }

        $transaksi->update(['status' => 'dikembalikan', 'denda' => $denda]);
        foreach ($transaksi->detailTransaksi as $detail) {
            $detail->buku->increment('stok');
        }

        $msg = $denda > 0
            ? "Buku berhasil dikembalikan. Denda: Rp " . number_format($denda, 0, ',', '.')
            : 'Buku berhasil dikembalikan. Terima kasih!';

        return back()->with('success', $msg);
    }
}
