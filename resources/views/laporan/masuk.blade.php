@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-semibold text-slate-900">Laporan Stok Masuk</h1>
        <p class="text-slate-500 mb-6">Laporan detail stok barang yang masuk ke Ruaya Space Coffee.</p>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('laporan.exportPdf', ['type' => 'masuk']) }}" class="inline-flex items-center gap-2 rounded-3xl bg-red-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-red-700 transition">📄 Export PDF</a>
            <a href="{{ route('laporan.exportExcel', ['type' => 'masuk']) }}" class="inline-flex items-center gap-2 rounded-3xl bg-green-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-green-700 transition">📊 Export Excel</a>
        </div>
    </div>

    <div class="rounded-3xl bg-white p-6 shadow-sm">
        <form method="GET" class="grid gap-4 md:grid-cols-[1fr_1fr_auto]">
            <input type="date" name="date_from" placeholder="Dari tanggal" value="{{ request('date_from') }}" class="rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 focus:border-emerald-600 focus:outline-none" />
            <input type="date" name="date_to" placeholder="Sampai tanggal" value="{{ request('date_to') }}" class="rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 focus:border-emerald-600 focus:outline-none" />
            <button type="submit" class="rounded-3xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white hover:bg-slate-800">Filter</button>
        </form>
    </div>

    @if($stokMasuks->count())
    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <table class="w-full text-sm text-slate-700">
            <thead class="bg-slate-100 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">Tanggal</th>
                    <th class="px-6 py-3 text-left font-semibold">Barang</th>
                    <th class="px-6 py-3 text-left font-semibold">Supplier</th>
                    <th class="px-6 py-3 text-right font-semibold">Kuantitas</th>
                    <th class="px-6 py-3 text-right font-semibold">Harga</th>
                    <th class="px-6 py-3 text-left font-semibold">User</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach($stokMasuks as $masuk)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4">{{ $masuk->tanggal_masuk->format('d/m/Y H:i') }}</td>
                    <td class="px-6 py-4">{{ $masuk->barang?->nama_barang ?? 'N/A' }}</td>
                    <td class="px-6 py-4">{{ $masuk->supplier?->nama_supplier ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-right font-medium">{{ $masuk->kuantitas }}</td>
                    <td class="px-6 py-4 text-right">Rp {{ number_format($masuk->harga_beli, 0, ',', '.') }}</td>
                    <td class="px-6 py-4">{{ $masuk->user?->name ?? 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $stokMasuks->links() }}
    @else
    <div class="rounded-3xl border-2 border-dashed border-slate-300 bg-slate-50 p-12 text-center">
        <p class="text-slate-500">Tidak ada data laporan stok masuk.</p>
    </div>
    @endif
</div>
@endsection
