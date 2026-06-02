<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Menu;
use App\Models\MenuRecipe;
use Illuminate\Http\Request;

class MenuRecipeController extends Controller
{
    public function index()
    {
        $recipes = MenuRecipe::with(['menu', 'barang'])->paginate(12);

        return view('menu-recipes.index', compact('recipes'));
    }

    public function create()
    {
        return view('menu-recipes.create', [
            'menus' => Menu::orderBy('nama_menu')->get(),
            'barangs' => Barang::orderBy('nama_barang')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'barang_id' => 'required|exists:barangs,id',
            'qty' => 'required|numeric|min:0.01',
        ]);

        MenuRecipe::create($validated);

        return redirect()->route('menu-recipes.index')->with('success', 'Resep menu berhasil ditambahkan.');
    }

    public function edit(MenuRecipe $menuRecipe)
    {
        return view('menu-recipes.edit', [
            'recipe' => $menuRecipe,
            'menus' => Menu::orderBy('nama_menu')->get(),
            'barangs' => Barang::orderBy('nama_barang')->get(),
        ]);
    }

    public function update(Request $request, MenuRecipe $menuRecipe)
    {
        $validated = $request->validate([
            'menu_id' => 'required|exists:menus,id',
            'barang_id' => 'required|exists:barangs,id',
            'qty' => 'required|numeric|min:0.01',
        ]);

        $menuRecipe->update($validated);

        return redirect()->route('menu-recipes.index')->with('success', 'Resep menu berhasil diperbarui.');
    }

    public function destroy(MenuRecipe $menuRecipe)
    {
        $menuRecipe->delete();

        return redirect()->route('menu-recipes.index')->with('success', 'Resep menu berhasil dihapus.');
    }
}
