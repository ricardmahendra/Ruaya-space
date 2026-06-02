@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-semibold text-slate-900">Laporan Stok</h1>
        <p class="text-slate-500 mb-2">Laporan detail stok barang dengan data masuk, keluar, sisa, dan persentase pemakaian.</p>
        <p class="text-slate-500">Periode: {{ $periodLabel ?? 'Bulan ini' }}</p>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('laporan.exportPdf', array_merge(['type' => 'stok'], request()->only(['month', 'year', 'date_from', 'date_to']))) }}" class="inline-flex items-center gap-2 rounded-3xl bg-red-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-red-700 transition">📄 Export PDF</a>
        </div>
    </div>

    <div class="rounded-3xl bg-white p-6 shadow-sm">
        @php
            $months = [
                '01' => 'Januari',
                '02' => 'Februari',
                '03' => 'Maret',
                '04' => 'April',
                '05' => 'Mei',
                '06' => 'Juni',
                '07' => 'Juli',
                '08' => 'Agustus',
                '09' => 'September',
                '10' => 'Oktober',
                '11' => 'November',
                '12' => 'Desember',
            ];
            $years = range(now()->year - 2, now()->year + 1);
        @endphp

        <form method="GET" class="grid gap-4 lg:grid-cols-[1fr_1fr_1fr_1fr_auto]">
            <div>
                <label class="sr-only" for="month">Bulan</label>
                <select id="month" name="month" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 focus:border-emerald-600 focus:outline-none">
                    @foreach($months as $value => $label)
                        <option value="{{ $value }}" {{ ($selectedMonth ?? now()->format('m')) === $value ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="sr-only" for="year">Tahun</label>
                <select id="year" name="year" class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 focus:border-emerald-600 focus:outline-none">
                    @foreach($years as $year)
                        <option value="{{ $year }}" {{ ($selectedYear ?? now()->format('Y')) == $year ? 'selected' : '' }}>{{ $year }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="rounded-3xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white hover:bg-slate-800">Filter</button>
        </form>
        <p class="mt-3 text-xs text-slate-500">Gunakan tanggal jika ingin filter rentang, atau pilih bulan/tahun untuk laporan bulanan.</p>
    </div>

    @if($barangs->count())
    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <table class="w-full text-sm text-slate-700">
            <thead class="bg-slate-100 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">Nama Barang</th>
                    <th class="px-6 py-3 text-left font-semibold">Kategori</th>
                    <th class="px-6 py-3 text-right font-semibold">Masuk</th>
                    <th class="px-6 py-3 text-right font-semibold">Keluar</th>
                    <th class="px-6 py-3 text-right font-semibold">Sisa</th>
                    <th class="px-6 py-3 text-right font-semibold">% Pemakaian</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach($barangs as $barang)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4">{{ $barang->nama_barang }}</td>
                    <td class="px-6 py-4">{{ $barang->kategori?->nama_kategori ?? 'N/A' }}</td>
                    <td class="px-6 py-4 text-right font-medium">{{ $barang->total_masuk }}</td>
                    <td class="px-6 py-4 text-right font-medium">{{ $barang->total_keluar }}</td>
                    <td class="px-6 py-4 text-right font-medium">{{ $barang->stok }}</td>
                    <td class="px-6 py-4 text-right font-medium">{{ $barang->usage_percentage }}%</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-slate-50 text-slate-900">
                <tr>
                    <td colspan="2" class="px-6 py-3 font-semibold">Total halaman</td>
                    <td class="px-6 py-3 text-right font-semibold">{{ $barangs->sum('total_masuk') }}</td>
                    <td class="px-6 py-3 text-right font-semibold">{{ $barangs->sum('total_keluar') }}</td>
                    <td class="px-6 py-3 text-right font-semibold">{{ $barangs->sum('stok') }}</td>
                    <td class="px-6 py-3 text-right font-semibold">-</td>
                </tr>
            </tfoot>
        </table>
    </div>

    {{ $barangs->links() }}
    @else
    <div class="rounded-3xl border-2 border-dashed border-slate-300 bg-slate-50 p-12 text-center">
        <p class="text-slate-500">Tidak ada data laporan stok.</p>
    </div>
    @endif
</div>
@endsection
