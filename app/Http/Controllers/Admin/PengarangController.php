<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengarang;
use Illuminate\Http\Request;

class PengarangController extends Controller
{
    public function index()
    {
        $pengarang = Pengarang::orderBy('nama')->get();
        return view('admin.pengarang.index', compact('pengarang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'biografi' => 'nullable|string',
        ], [
            'nama.required' => 'Nama pengarang wajib diisi.',
        ]);

        Pengarang::create($request->only('nama', 'biografi'));

        return redirect()->route('admin.pengarang.index')
                         ->with('success', 'Pengarang berhasil ditambahkan.');
    }

    public function update(Request $request, string $id)
    {
        $pengarang = Pengarang::findOrFail($id);

        $request->validate([
            'nama'     => 'required|string|max:255',
            'biografi' => 'nullable|string',
        ], [
            'nama.required' => 'Nama pengarang wajib diisi.',
        ]);

        $pengarang->update($request->only('nama', 'biografi'));

        return redirect()->route('admin.pengarang.index')
                         ->with('success', 'Data pengarang berhasil diupdate.');
    }

    public function destroy(string $id)
    {
        $pengarang = Pengarang::findOrFail($id);
        $pengarang->delete();

        return redirect()->route('admin.pengarang.index')
                         ->with('success', 'Pengarang berhasil dihapus.');
    }
}
