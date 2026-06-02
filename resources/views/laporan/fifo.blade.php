@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-semibold text-slate-900">Laporan FIFO</h1>
        <p class="text-slate-500 mb-6">Laporan First In First Out (FIFO) untuk pelacakan stok barang.</p>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('laporan.exportPdf', ['type' => 'fifo']) }}" class="inline-flex items-center gap-2 rounded-3xl bg-red-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-red-700 transition">📄 Export PDF</a>
            <a href="{{ route('laporan.exportExcel', ['type' => 'fifo']) }}" class="inline-flex items-center gap-2 rounded-3xl bg-green-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-green-700 transition">📊 Export Excel</a>
        </div>
    </div>

    @if($histories->count())
    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <table class="w-full text-sm text-slate-700">
            <thead class="bg-slate-100 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">Tanggal Pengambilan</th>
                    <th class="px-6 py-3 text-left font-semibold">Barang</th>
                    <th class="px-6 py-3 text-right font-semibold">Kuantitas</th>
                    <th class="px-6 py-3 text-left font-semibold">Stok Masuk</th>
                    <th class="px-6 py-3 text-left font-semibold">Stok Keluar</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach($histories as $history)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4">{{ $history->tanggal_pengambilan->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4">{{ $history->barang?->nama_barang ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-right font-medium">{{ $history->kuantitas }}</td>
                    <td class="px-6 py-4">{{ $history->stokMasuk?->tanggal_masuk->format('d/m/Y') ?? 'N/A' }}</td>
                    <td class="px-6 py-4">{{ $history->stokKeluar?->tanggal_keluar->format('d/m/Y') ?? 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $histories->links() }}
    @else
    <div class="rounded-3xl border-2 border-dashed border-slate-300 bg-slate-50 p-12 text-center">
        <p class="text-slate-500">Tidak ada data FIFO history.</p>
    </div>
    @endif
</div>
@endsection
