<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->paginate(12);
        return view('kategoris.index', compact('kategoris'));
    }

    public function create()
    {
        return view('kategoris.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'slug' => 'required|string|max:255|unique:kategoris,slug',
        ]);

        $kategori = Kategori::create($data);
        ActivityLogService::log('CREATE', "Menambahkan kategori {$kategori->nama_kategori}", Kategori::class, $kategori->id);

        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(Kategori $kategori)
    {
        return view('kategoris.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $data = $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'slug' => 'required|string|max:255|unique:kategoris,slug,'.$kategori->id,
        ]);

        $kategori->update($data);
        ActivityLogService::log('UPDATE', "Memperbarui kategori {$kategori->nama_kategori}", Kategori::class, $kategori->id);

        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(Kategori $kategori)
    {
        if ($kategori->barangs()->exists()) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena memiliki barang terkait.');
        }

        $kategori->delete();
        ActivityLogService::log('DELETE', "Menghapus kategori {$kategori->nama_kategori}", Kategori::class, $kategori->id);

        return redirect()->route('kategoris.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
