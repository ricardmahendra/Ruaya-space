@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-slate-900">Tambah Resep Menu</h1>
            <p class="text-slate-500">Tentukan bahan dan jumlah yang diperlukan untuk menu.</p>
        </div>
        <a href="{{ route('menu-recipes.index') }}" class="rounded-3xl bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-200">Kembali</a>
    </div>

    <div class="rounded-3xl bg-white p-8 shadow-sm">
        <form action="{{ route('menu-recipes.store') }}" method="POST" class="grid gap-6">
            @csrf
            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label class="text-sm font-medium text-slate-700">Menu</label>
                    <select name="menu_id" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700" required>
                        <option value="">Pilih menu</option>
                        @foreach($menus as $menu)
                            <option value="{{ $menu->id }}" {{ old('menu_id') == $menu->id ? 'selected' : '' }}>{{ $menu->nama_menu }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-700">Bahan</label>
                    <select name="barang_id" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700" required>
                        <option value="">Pilih bahan</option>
                        @foreach($barangs as $barang)
                            <option value="{{ $barang->id }}" {{ old('barang_id') == $barang->id ? 'selected' : '' }}>{{ $barang->nama_barang }} ({{ $barang->satuan }})</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="text-sm font-medium text-slate-700">Qty</label>
                <input type="number" step="0.01" name="qty" value="{{ old('qty') }}" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700" required />
                <p class="mt-2 text-xs text-slate-500">Masukkan jumlah bahan dalam satuan terkecil sesuai produk.</p>
            </div>

            <button type="submit" class="rounded-3xl border border-black bg-gradient-to-r from-slate-400 via-slate-600 to-slate-900 px-6 py-3 text-sm font-medium text-black shadow-md hover:from-slate-500 hover:via-slate-700 hover:to-black transition">Simpan Resep</button>
        </form>
    </div>
</div>
@endsection
