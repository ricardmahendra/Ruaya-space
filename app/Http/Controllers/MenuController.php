<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::latest()->paginate(12);

        return view('menus.index', compact('menus'));
    }

    public function create()
    {
        return view('menus.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode_menu' => 'required|string|max:255|unique:menus,kode_menu',
            'nama_menu' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_available' => 'nullable|boolean',
        ]);

        $validated['is_available'] = $request->boolean('is_available');

        if ($request->hasFile('gambar')) {
            try {
                $folder = storage_path('app/public/menus');
                if (!is_dir($folder)) {
                    mkdir($folder, 0755, true);
                }
                $path = $request->file('gambar')->store('menus', 'public');
                $validated['gambar'] = $path;
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal mengunggah gambar: ' . $e->getMessage());
            }
        }

        Menu::create($validated);

        return redirect()->route('menus.index')->with('success', 'Menu berhasil ditambahkan.');
    }

    public function edit(Menu $menu)
    {
        return view('menus.edit', compact('menu'));
    }

    public function update(Request $request, Menu $menu)
    {
        $validated = $request->validate([
            'kode_menu' => 'required|string|max:255|unique:menus,kode_menu,' . $menu->id,
            'nama_menu' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'is_available' => 'nullable|boolean',
        ]);

        $validated['is_available'] = $request->boolean('is_available');

        if ($request->hasFile('gambar')) {
            try {
                $folder = storage_path('app/public/menus');
                if (!is_dir($folder)) {
                    mkdir($folder, 0755, true);
                }
                if ($menu->gambar && Storage::disk('public')->exists($menu->gambar)) {
                    Storage::disk('public')->delete($menu->gambar);
                }
                $path = $request->file('gambar')->store('menus', 'public');
                $validated['gambar'] = $path;
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Gagal mengunggah gambar: ' . $e->getMessage());
            }
        }

        $menu->update($validated);

        return redirect()->route('menus.index')->with('success', 'Menu berhasil diperbarui.');
    }

    public function destroy(Menu $menu)
    {
        $menu->delete();

        return redirect()->route('menus.index')->with('success', 'Menu berhasil dihapus.');
    }
}
