@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-semibold text-slate-900">Laporan Stok Menipis</h1>
        <p class="text-slate-500 mb-6">Laporan barang-barang dengan stok yang menipis atau akan habis.</p>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('laporan.exportPdf', ['type' => 'menipis']) }}" class="inline-flex items-center gap-2 rounded-3xl bg-red-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-red-700 transition">📄 Export PDF</a>
            <a href="{{ route('laporan.exportExcel', ['type' => 'menipis']) }}" class="inline-flex items-center gap-2 rounded-3xl bg-green-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-green-700 transition">📊 Export Excel</a>
        </div>
    </div>

    @if($barangs->count())
    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <table class="w-full text-sm text-slate-700">
            <thead class="bg-slate-100 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">Nama Barang</th>
                    <th class="px-6 py-3 text-left font-semibold">Kategori</th>
                    <th class="px-6 py-3 text-right font-semibold">Stok Saat Ini</th>
                    <th class="px-6 py-3 text-right font-semibold">Minimum Stok</th>
                    <th class="px-6 py-3 text-left font-semibold">Keterangan</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach($barangs as $barang)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4 font-medium">{{ $barang->nama_barang }}</td>
                    <td class="px-6 py-4">{{ $barang->kategori?->nama_kategori ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-right">
                        <span class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-bold text-yellow-900">{{ $barang->stok }}</span>
                    </td>
                    <td class="px-6 py-4 text-right">{{ $barang->reorder_point }}</td>
                    <td class="px-6 py-4">
                        @if($barang->stok <= 0)
                            <span class="text-red-600 font-semibold">Stok Habis</span>
                        @else
                            <span class="text-yellow-600">Pesan {{ $barang->reorder_point - $barang->stok }} unit</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $barangs->links() }}
    @else
    <div class="rounded-3xl border-2 border-dashed border-slate-300 bg-slate-50 p-12 text-center">
        <p class="text-slate-500">Semua barang memiliki stok yang cukup.</p>
    </div>
    @endif
</div>
@endsection
