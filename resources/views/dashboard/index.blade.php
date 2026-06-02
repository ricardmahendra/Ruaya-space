@extends('layouts.app')

@section('content')
<div class="space-y-8">
    <div class="rounded-3xl bg-white p-8 shadow-sm">
        <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
                <h1 class="text-3xl font-semibold text-slate-900">Hallo Sir, {{ auth()->user()->name }}.</h1>
                <p class="text-slate-500">Here is what's happening at Ruaya Space today.</p>
            </div>
            <div class="inline-flex items-center gap-2 rounded-2xl bg-slate-50 px-4 py-3 text-sm text-slate-600">Monthly view</div>
        </div>
        <div class="mt-8 grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @component('components.stat-card', ['title' => "TODAY'S TOTAL ITEMS", 'value' => number_format($total_barang), 'badge' => '+12% vs last month'])
            @endcomponent
            @component('components.stat-card', ['title' => 'TOTAL MENU', 'value' => number_format($total_menu), 'badge' => 'Master Menu'])
            @endcomponent
            @component('components.stat-card', ['title' => 'TOTAL BAHAN MENU', 'value' => number_format($total_resep), 'badge' => 'Recipe Items'])
            @endcomponent
            @component('components.stat-card', ['title' => 'LOW STOCK ALERTS', 'value' => number_format($barang_menipis), 'badge' => 'Critical'])
            @endcomponent
            @component('components.stat-card', ['title' => 'BARANG MASUK HARI INI', 'value' => number_format($barang_masuk_hari), 'badge' => 'Real time'])
            @endcomponent
            @component('components.stat-card', ['title' => 'BARANG KELUAR HARI INI', 'value' => number_format($barang_keluar_hari), 'badge' => 'Real time'])
            @endcomponent
        </div>
    </div>

    <div class="grid gap-6">
        <div class="rounded-3xl bg-white p-8 shadow-sm">
            <div class="flex items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Monthly Stock Trends</h2>
                    <p class="text-sm text-slate-500">Analisis stok persediaan per kategori.</p>
                </div>
                <div class="rounded-2xl bg-slate-50 px-4 py-2 text-sm text-slate-600">Year</div>
            </div>
            <canvas id="stockChart" class="mt-6"></canvas>
        </div>
    </div>

    <div class="rounded-3xl bg-white p-8 shadow-sm">
        <div class="flex items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="text-xl font-semibold text-slate-900">Inventory Focus</h2>
                <p class="text-sm text-slate-500">Barang dengan stok terendah dan fokus attention.</p>
            </div>
            <div class="rounded-2xl bg-slate-50 px-4 py-2 text-sm text-slate-600">Updated hourly</div>
        </div>
        <div class="grid gap-4 md:grid-cols-2">
            @foreach($inventory_focus as $item)
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                    <div class="flex items-center justify-between gap-4">
                        <div>
                            <div class="text-sm font-semibold text-slate-900">{{ $item->nama_barang }}</div>
                            <div class="text-sm text-slate-500">{{ $item->kategori->nama_kategori }}</div>
                        </div>
                        <div class="text-right">
                            <div class="text-2xl font-semibold text-slate-900">{{ $item->stok }}</div>
                            <div class="text-xs uppercase tracking-[0.2em] text-slate-500">{{ $item->satuan }}</div>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center justify-between gap-3">
                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">{{ strtoupper($item->status_stok) }}</span>
                        <span class="text-sm text-slate-500">ROP: {{ $item->reorder_point }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    const ctx = document.getElementById('stockChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chart_transaksi['labels']) !!},
                datasets: [{
                    label: 'Stock Out',
                    data: {!! json_encode($chart_transaksi['values']) !!},
                    borderColor: '#16a34a',
                    backgroundColor: 'rgba(22,163,74,0.16)',
                    tension: 0.4,
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                },
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }
</script>
@endpush
