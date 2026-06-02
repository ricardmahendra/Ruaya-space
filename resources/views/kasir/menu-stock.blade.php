@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="rounded-3xl bg-white p-8 shadow-sm">
        <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
                <h1 class="text-3xl font-semibold text-slate-900">Stok Menu</h1>
                <p class="text-slate-500">Lihat ketersediaan jumlah menu berdasarkan bahan resep.</p>
            </div>
            <a href="{{ route('kasir.dashboard') }}" class="rounded-3xl bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-200">Kembali ke Dashboard</a>
        </div>

        <div class="mt-8 grid gap-6">
            @forelse($menus as $menu)
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-slate-900">{{ $menu->nama_menu }}</h2>
                            <p class="text-sm text-slate-500">Harga: Rp{{ number_format($menu->harga, 0, ',', '.') }}</p>
                        </div>
                        <div class="rounded-3xl bg-white px-4 py-3 text-sm font-semibold text-slate-900 shadow-sm">Stok: {{ $menu->available_quantity }}</div>
                    </div>
                    <div class="mt-4 grid gap-3 sm:grid-cols-2">
                        @foreach($menu->recipes as $recipe)
                            <div class="rounded-3xl border border-slate-200 bg-white p-4">
                                <div class="text-sm font-semibold text-slate-900">{{ $recipe->barang->nama_barang }}</div>
                                <div class="text-sm text-slate-500">Kebutuhan: {{ $recipe->qty }} {{ $recipe->barang->satuan }}</div>
                                <div class="text-sm text-slate-500">Stok bahan: {{ $recipe->barang->qty }} {{ $recipe->barang->satuan }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @empty
                <div class="rounded-3xl border border-slate-200 bg-white p-6 text-center text-slate-500">Belum ada menu untuk ditampilkan.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
