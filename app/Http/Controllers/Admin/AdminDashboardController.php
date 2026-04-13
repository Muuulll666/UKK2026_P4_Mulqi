<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Buku;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_anggota'   => User::where('role', 'anggota')->count(),
            'total_petugas'   => User::where('role', 'petugas')->count(),
            'total_buku'      => Buku::count(),
            'total_dipinjam'  => 0,
            'menunggu'        => 0,
            'terlambat'       => 0,
        ];

        $transaksiTerbaru = collect(); // kosong dulu

        return view('admin.index', compact('stats', 'transaksiTerbaru'));
    }
}