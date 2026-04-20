<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Buku;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanController extends Controller {
    public function index(Request $request) {
        $bulan  = $request->get('bulan', now()->month);
        $tahun  = $request->get('tahun', now()->year);

        $transaksi = Transaksi::with(['user', 'detailTransaksi.buku'])
            ->whereMonth('tanggal_pinjam', $bulan)
            ->whereYear('tanggal_pinjam', $tahun)
            ->orderByDesc('id')
            ->get();

        $stats = [
            'total'        => $transaksi->count(),
            'dipinjam'     => $transaksi->where('status', 'dipinjam')->count(),
            'dikembalikan' => $transaksi->where('status', 'dikembalikan')->count(),
            'ditolak'      => $transaksi->where('status', 'ditolak')->count(),
            'menunggu'     => $transaksi->where('status', 'menunggu')->count(),
            'total_denda'  => $transaksi->sum('denda'),
        ];

        $bulanList = collect(range(1, 12))->map(fn($m) => ['value' => $m, 'label' => Carbon::create()->month($m)->locale('id')->isoFormat('MMMM')]);
        $tahunList = range(now()->year, now()->year - 3);

        return view('admin.laporan.index', compact('transaksi', 'stats', 'bulan', 'tahun', 'bulanList', 'tahunList'));
    }
}
