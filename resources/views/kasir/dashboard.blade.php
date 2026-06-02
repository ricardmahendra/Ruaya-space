@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="rounded-3xl bg-white p-8 shadow-sm">
        <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
                <h1 class="text-3xl font-semibold text-slate-900">Dashboard Kasir</h1>
                <p class="text-slate-500">Ringkasan penjualan dan status shift untuk kasir Anda.</p>
            </div>
            <div class="inline-flex items-center gap-2 rounded-2xl bg-slate-50 px-4 py-3 text-sm text-slate-600">Kasir</div>
        </div>
        <div class="mt-8 grid gap-4 md:grid-cols-4">
            @component('components.stat-card', ['title' => 'Total Penjualan Hari Ini', 'value' => 'Rp' . number_format($totalSales, 0, ',', '.'), 'badge' => 'Real time'])
            @endcomponent
            @component('components.stat-card', ['title' => 'Jumlah Transaksi', 'value' => number_format($transactionCount), 'badge' => 'Hari ini'])
            @endcomponent
            @component('components.stat-card', ['title' => 'Shift Aktif', 'value' => $activeShift ? 'Ya' : 'Tidak', 'badge' => $activeShift ? 'Dibuka pada ' . optional($activeShift->opened_at)->format('H:i') : 'Tutup'])
            @endcomponent
            @component('components.stat-card', ['title' => 'Item di Keranjang', 'value' => number_format($cartCount), 'badge' => 'POS'])
            @endcomponent
        </div>
    </div>

    <div class="grid gap-6 xl:grid-cols-[1.8fr_1fr]">
        <div class="rounded-3xl bg-white p-8 shadow-sm">
            <div class="flex items-center justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Transaksi Terbaru</h2>
                    <p class="text-sm text-slate-500">Lihat transaksi terakhir yang Anda lakukan.</p>
                </div>
                <a href="{{ route('kasir.history') }}" class="text-sm font-semibold text-slate-900 hover:text-slate-700">Lihat semua</a>
            </div>
            <div class="space-y-4">
                @forelse($latestSales as $sale)
                    <div class="rounded-3xl border border-slate-200 p-4">
                        <div class="flex items-center justify-between gap-4">
                            <div>
                                <div class="font-semibold text-slate-900">{{ $sale->nomor_transaksi }}</div>
                                <div class="text-sm text-slate-500">{{ $sale->tanggal_transaksi->format('d M Y H:i') }}</div>
                            </div>
                            <div class="text-right">
                                <div class="font-semibold text-slate-900">Rp{{ number_format($sale->total, 0, ',', '.') }}</div>
                                <div class="text-xs uppercase tracking-[0.2em] text-slate-500">{{ ucfirst($sale->metode_bayar) }}</div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="rounded-3xl border border-slate-200 p-6 text-center text-slate-500">Belum ada transaksi hari ini.</div>
                @endforelse
            </div>
        </div>

        <div class="rounded-3xl bg-white p-8 shadow-sm">
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-slate-900">Quick Actions</h2>
                <p class="text-sm text-slate-500">Akses cepat ke fitur kasir.</p>
            </div>
            <div class="grid gap-3">
                <a href="{{ route('kasir.pos') }}" class="block rounded-3xl bg-slate-900 px-5 py-4 text-sm font-semibold text-white hover:bg-slate-800">Buka Point of Sale</a>
                <a href="{{ route('kasir.menu-stock') }}" class="block rounded-3xl bg-emerald-100 px-5 py-4 text-sm font-semibold text-emerald-800 hover:bg-emerald-200">Cek Stok Menu</a>
                <a href="{{ route('kasir.history') }}" class="block rounded-3xl bg-slate-100 px-5 py-4 text-sm font-semibold text-slate-900 hover:bg-slate-200">Riwayat Transaksi</a>
            </div>
        </div>
    </div>
</div>
@endsection
