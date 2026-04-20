<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller {
    public function index() {
        $kategori = Kategori::withCount('buku')->orderBy('nama')->get();
        return view('admin.kategori.index', compact('kategori'));
    }

    public function store(Request $request) {
        $request->validate(['nama' => 'required|string|max:255|unique:kategori,nama', 'deskripsi' => 'nullable|string|max:500']);
        Kategori::create($request->only('nama', 'deskripsi'));
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, string $id) {
        $kategori = Kategori::findOrFail($id);
        $request->validate(['nama' => 'required|string|max:255|unique:kategori,nama,'.$id, 'deskripsi' => 'nullable|string|max:500']);
        $kategori->update($request->only('nama', 'deskripsi'));
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diupdate.');
    }

    public function destroy(string $id) {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
