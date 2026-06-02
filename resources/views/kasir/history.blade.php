@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen p-6">
    <div class="w-full max-w-full mx-auto space-y-6">
        <div class="rounded-3xl bg-white p-8 shadow-sm">
            <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
                <div>
                    <h1 class="text-3xl font-semibold text-slate-900">Riwayat Transaksi</h1>
                    <p class="text-slate-500">Semua transaksi yang Anda lakukan sebagai kasir.</p>
                </div>
                <a href="{{ route('kasir.dashboard') }}" class="rounded-3xl bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-200">Kembali ke Dashboard</a>
            </div>

            <div class="mt-6 grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5 shadow-sm">
                    <div class="text-sm text-slate-500">Jumlah Transaksi</div>
                    <div class="mt-2 text-3xl font-semibold text-slate-900">{{ $sales->total() }}</div>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5 shadow-sm">
                    <div class="text-sm text-slate-500">Pendapatan Halaman Ini</div>
                    <div class="mt-2 text-3xl font-semibold text-slate-900">Rp{{ number_format($sales->sum('total'), 0, ',', '.') }}</div>
                </div>
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5 shadow-sm">
                    <div class="text-sm text-slate-500">Transaksi Terbaru</div>
                    <div class="mt-2 text-3xl font-semibold text-slate-900">{{ optional($sales->first())->nomor_transaksi ?? '-' }}</div>
                </div>
            </div>
        </div>

        <div class="rounded-3xl bg-white p-6 shadow-sm">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <h2 class="text-xl font-semibold text-slate-900">Daftar Transaksi</h2>
                    <p class="text-sm text-slate-500">Lihat detail setiap transaksi yang sudah dicatat.</p>
                </div>
                <div class="flex items-center gap-2 text-sm text-slate-500">
                    <span class="rounded-full bg-slate-100 px-3 py-2">Halaman {{ $sales->currentPage() }} dari {{ $sales->lastPage() }}</span>
                </div>
            </div>

            <div class="mt-6 overflow-x-auto rounded-3xl border border-slate-200 w-full">
                <table class="w-full min-w-full divide-y divide-slate-200 text-sm text-slate-700">
                    <thead class="bg-slate-50 text-slate-900">
                        <tr>
                            <th class="px-6 py-4 text-left font-semibold uppercase tracking-[0.08em]">Nomor</th>
                            <th class="px-6 py-4 text-left font-semibold uppercase tracking-[0.08em]">Tanggal</th>
                            <th class="px-6 py-4 text-left font-semibold uppercase tracking-[0.08em]">Total</th>
                            <th class="px-6 py-4 text-left font-semibold uppercase tracking-[0.08em]">Metode</th>
                            <th class="px-6 py-4 text-left font-semibold uppercase tracking-[0.08em]">Status</th>
                            <th class="px-6 py-4 text-left font-semibold uppercase tracking-[0.08em]">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse($sales as $sale)
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4 font-medium text-slate-900">{{ $sale->nomor_transaksi }}</td>
                                <td class="px-6 py-4 text-slate-700">{{ $sale->tanggal_transaksi->format('d M Y H:i') }}</td>
                                <td class="px-6 py-4 font-semibold text-slate-900">Rp{{ number_format($sale->total, 0, ',', '.') }}</td>
                                <td class="px-6 py-4 text-slate-700">{{ ucfirst($sale->metode_bayar) }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">Selesai</span>
                                </td>
                                <td class="px-6 py-4">
                                    <a href="{{ route('kasir.receipt', $sale) }}" class="inline-flex rounded-full bg-slate-900 px-4 py-2 text-xs font-semibold text-white hover:bg-slate-800">Lihat Struk</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center text-slate-500">Belum ada transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                <div class="text-sm text-slate-500">Menampilkan {{ $sales->count() }} dari {{ $sales->total() }} transaksi.</div>
                <div>
                    {{ $sales->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
