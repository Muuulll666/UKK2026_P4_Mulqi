<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anggota;
use App\Models\Kelas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AnggotaController extends Controller
{
    public function index()
    {
        $anggota = Anggota::with(['user', 'kelas'])->get();
        $kelas   = Kelas::orderBy('nama_kelas')->get();
        return view('admin.anggota.index', compact('anggota', 'kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'kelas_id' => 'required|exists:kelas,id',
        ], [
            'nama.required'     => 'Nama wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'email.unique'      => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
            'kelas_id.required' => 'Kelas wajib dipilih.',
            'kelas_id.exists'   => 'Kelas tidak valid.',
        ]);

        $user = User::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'anggota',
        ]);

        Anggota::create([
            'user_id'  => $user->id,
            'kelas_id' => $request->kelas_id,
        ]);

        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function update(Request $request, string $id)
    {
        $anggota = Anggota::findOrFail($id);

        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $anggota->user_id,
            'kelas_id' => 'required|exists:kelas,id',
            'password' => 'nullable|min:6',
        ], [
            'nama.required'     => 'Nama wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'email.unique'      => 'Email sudah terdaftar.',
            'kelas_id.required' => 'Kelas wajib dipilih.',
            'password.min'      => 'Password minimal 6 karakter.',
        ]);

        $data = [
            'nama'  => $request->nama,
            'email' => $request->email,
        ];
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        $anggota->user->update($data);
        $anggota->update(['kelas_id' => $request->kelas_id]);

        return redirect()->route('admin.anggota.index')->with('success', 'Data anggota berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        $anggota = Anggota::findOrFail($id);
        $anggota->user->delete(); // cascade deletes anggota too
        return redirect()->route('admin.anggota.index')->with('success', 'Anggota berhasil dihapus.');
    }
}
