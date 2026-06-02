@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-slate-900">Resep Menu</h1>
            <p class="text-slate-500">Kelola bahan baku untuk setiap menu.</p>
        </div>
        <a href="{{ route('menu-recipes.create') }}" class="rounded-3xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white hover:bg-slate-800">Tambah Resep</a>
    </div>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <table class="w-full text-sm text-slate-700">
            <thead class="bg-slate-100 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">Menu</th>
                    <th class="px-6 py-3 text-left font-semibold">Bahan</th>
                    <th class="px-6 py-3 text-right font-semibold">Qty</th>
                    <th class="px-6 py-3 text-left font-semibold">Satuan</th>
                    <th class="px-6 py-3 text-right font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($recipes as $recipe)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4">{{ $recipe->menu->nama_menu }}</td>
                    <td class="px-6 py-4">{{ $recipe->barang->nama_barang }}</td>
                    <td class="px-6 py-4 text-right">{{ $recipe->qty }}</td>
                    <td class="px-6 py-4">{{ $recipe->barang->satuan }}</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('menu-recipes.edit', $recipe) }}" class="rounded-2xl bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-200">Edit</a>
                        <form action="{{ route('menu-recipes.destroy', $recipe) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus resep ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-2xl bg-red-100 px-3 py-2 text-xs font-semibold text-red-700 hover:bg-red-200">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-12 text-center text-slate-500">Belum ada resep menu.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $recipes->links() }}
</div>
@endsection
