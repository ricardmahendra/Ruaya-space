@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-slate-900">Stok Keluar</h1>
            <p class="text-slate-500">Catat semua pengeluaran bahan dan produk.</p>
        </div>
        <a href="{{ route('stok-keluar.create') }}" class="rounded-3xl border border-black bg-gradient-to-r from-amber-200 to-amber-400 px-5 py-3 text-sm font-medium text-black shadow-sm hover:from-amber-300 hover:to-amber-500 transition">Tambah Stok Keluar</a>
    </div>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <table class="w-full text-left text-sm text-slate-700">
            <thead class="bg-slate-50 text-slate-500">
                <tr>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Item</th>
                    <th class="px-6 py-4">Jumlah</th>
                    <th class="px-6 py-4">Tujuan</th>
                    <th class="px-6 py-4">User</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach($stokKeluars as $item)
                <tr>
                    <td class="px-6 py-4">{{ $item->tanggal_keluar->format('Y-m-d') }}</td>
                    <td class="px-6 py-4">{{ $item->barang->nama_barang ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $item->jumlah }} {{ $item->barang?->satuan }}</td>
                    <td class="px-6 py-4">{{ $item->tujuan_penggunaan }}</td>
                    <td class="px-6 py-4">{{ $item->user->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @include('components.pagination', ['paginator' => $stokKeluars])
</div>
@endsection
