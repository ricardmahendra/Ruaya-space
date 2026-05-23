@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-slate-900">Detail Barang</h1>
            <p class="text-slate-500">Informasi lengkap dan histori stok FIFO.</p>
        </div>
        <a href="{{ route('barangs.index') }}" class="rounded-3xl bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-200">Kembali</a>
    </div>

    <div class="grid gap-6 lg:grid-cols-[1.2fr_0.8fr]">
        <div class="rounded-3xl bg-white p-8 shadow-sm">
            <div class="flex items-center gap-5">
                <div class="h-20 w-20 rounded-3xl bg-slate-100 flex items-center justify-center text-3xl text-slate-500">{{ strtoupper(substr($barang->nama_barang, 0, 1)) }}</div>
                <div>
                    <div class="text-2xl font-semibold text-slate-900">{{ $barang->nama_barang }}</div>
                    <div class="text-sm text-slate-500">{{ $barang->kategori->nama_kategori }}</div>
                </div>
            </div>
            <div class="mt-8 grid gap-4 md:grid-cols-2">
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                    <div class="text-slate-500 text-xs uppercase tracking-[0.2em]">Kode Barang</div>
                    <div class="mt-2 text-lg font-semibold text-slate-900">{{ $barang->kode_barang }}</div>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                    <div class="text-slate-500 text-xs uppercase tracking-[0.2em]">Stock</div>
                    <div class="mt-2 text-lg font-semibold text-slate-900">{{ $barang->stok }} {{ $barang->satuan }}</div>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                    <div class="text-slate-500 text-xs uppercase tracking-[0.2em]">Reorder Point</div>
                    <div class="mt-2 text-lg font-semibold text-slate-900">{{ $barang->reorder_point }}</div>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                    <div class="text-slate-500 text-xs uppercase tracking-[0.2em]">Status</div>
                    <div class="mt-2">@include('components.stock-badge', ['status' => $barang->status_stok])</div>
                </div>
            </div>
            <div class="mt-8">
                <h2 class="text-xl font-semibold text-slate-900">Deskripsi</h2>
                <p class="mt-3 text-sm text-slate-600">{{ $barang->deskripsi ?? 'Belum ada deskripsi untuk barang ini.' }}</p>
            </div>
        </div>
        <div class="rounded-3xl bg-white p-8 shadow-sm">
            <h2 class="text-xl font-semibold text-slate-900">History FIFO</h2>
            <div class="mt-6 space-y-4">
                @forelse($barang->fifoHistories as $history)
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                        <div class="flex items-center justify-between gap-2">
                            <div class="font-semibold text-slate-900">Batch ID: {{ $history->stok_masuk->batch_code ?? 'N/A' }}</div>
                            <div class="text-sm text-slate-500">{{ $history->tanggal_pengambilan->format('Y-m-d') }}</div>
                        </div>
                        <div class="mt-2 text-sm text-slate-600">Diambil: {{ $history->jumlah_diambil }} {{ $barang->satuan }}</div>
                    </div>
                @empty
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">Belum ada riwayat FIFO untuk barang ini.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
