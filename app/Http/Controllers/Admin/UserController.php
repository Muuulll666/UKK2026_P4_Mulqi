<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $role   = $request->get('role');

        $query = User::query()
            ->when($search, fn($q) => $q->where('nama', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%"))
            ->when($role, fn($q) => $q->where('role', $role))
            ->orderBy('nama');

        $admins   = (clone $query)->where('role', 'admin')->get();
        $petugas  = (clone $query)->where('role', 'petugas')->get();
        $anggota  = (clone $query)->where('role', 'anggota')->get();

        // Jika ada filter role spesifik, override
        if ($role === 'admin')   { $petugas = collect(); $anggota = collect(); }
        if ($role === 'petugas') { $admins  = collect(); $anggota = collect(); }
        if ($role === 'anggota') { $admins  = collect(); $petugas = collect(); }

        return view('admin.user.index', compact('admins', 'petugas', 'anggota', 'search', 'role'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role'     => 'required|in:admin,petugas,anggota',
        ], [
            'nama.required'     => 'Nama wajib diisi.',
            'email.required'    => 'Email wajib diisi.',
            'email.unique'      => 'Email sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal 6 karakter.',
            'role.required'     => 'Role wajib dipilih.',
        ]);

        User::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email,' . $user->id,
            'role'     => 'required|in:admin,petugas,anggota',
            'password' => 'nullable|min:6',
        ], [
            'nama.required'  => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.unique'   => 'Email sudah terdaftar.',
            'role.required'  => 'Role wajib dipilih.',
            'password.min'   => 'Password minimal 6 karakter.',
        ]);

        $data = [
            'nama'  => $request->nama,
            'email' => $request->email,
            'role'  => $request->role,
        ];
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);
        return redirect()->route('admin.user.index')->with('success', 'Data user berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.user.index')->with('error', 'Tidak bisa menghapus akun sendiri.');
        }
        $user->delete();
        return redirect()->route('admin.user.index')->with('success', 'User berhasil dihapus.');
    }
}
