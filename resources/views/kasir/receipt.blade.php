@extends('layouts.app')

@section('content')
<div class="flex justify-center py-8 px-4">
    <div class="w-full max-w-[360px] rounded-3xl bg-white p-6 shadow-sm print:max-w-[320px] print:border-none">
        <div class="flex items-center justify-between border-b border-slate-200 pb-4">
            <div>
                <h1 class="text-xl font-semibold uppercase tracking-[0.2em] text-slate-900">Ruaya Space</h1>
                <p class="text-[11px] text-slate-500">Coffee Atelier</p>
            </div>
            <a href="{{ route('kasir.history') }}" class="hidden print:hidden rounded-full bg-slate-100 px-4 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-200">Kembali</a>
        </div>

        <div class="mt-4 space-y-3 text-[11px] text-slate-600">
            <div class="flex justify-between">
                <span>Nomor</span>
                <span class="font-semibold text-slate-900">{{ $sale->nomor_transaksi }}</span>
            </div>
            <div class="flex justify-between">
                <span>Tanggal</span>
                <span class="font-semibold text-slate-900">{{ $sale->tanggal_transaksi->format('d M Y H:i') }}</span>
            </div>
            <div class="flex justify-between">
                <span>Kasir</span>
                <span class="font-semibold text-slate-900">{{ $sale->user->name }}</span>
            </div>
        </div>

        <div class="mt-6 border-t border-slate-200 pt-4 text-[12px] text-slate-700">
            @foreach($sale->saleDetails as $detail)
                <div class="mb-3">
                    <div class="flex justify-between gap-4">
                        <span class="font-semibold">{{ Str::limit($detail->nama_menu, 26, '...') }}</span>
                        <span class="font-semibold">Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="mt-1 flex justify-between text-[11px] text-slate-500">
                        <span>{{ $detail->qty }} x Rp{{ number_format($detail->harga, 0, ',', '.') }}</span>
                        <span>{{ number_format($detail->qty * $detail->harga, 0, ',', '.') }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-2 border-t border-slate-200 pt-3 text-[12px] text-slate-700">
            <div class="flex justify-between py-1">
                <span>Subtotal</span>
                <span>Rp{{ number_format($sale->total, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between py-1">
                <span>Bayar</span>
                <span>Rp{{ number_format($sale->bayar, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between py-1">
                <span>Kembali</span>
                <span>Rp{{ number_format($sale->kembalian, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between pt-3 text-sm font-semibold text-slate-900">
                <span>Total</span>
                <span>Rp{{ number_format($sale->total, 0, ',', '.') }}</span>
            </div>
        </div>

        <div class="mt-4 border-t border-slate-200 pt-3 text-[11px] text-slate-600">
            <div class="flex justify-between mb-2">
                <span>Metode</span>
                <span class="font-semibold">{{ ucfirst($sale->metode_bayar) }}</span>
            </div>
            @if($sale->catatan)
                <div class="mb-2">
                    <span class="font-semibold text-slate-900">Catatan:</span>
                    <p class="text-[11px] text-slate-600">{{ $sale->catatan }}</p>
                </div>
            @endif
            <p class="text-center text-[11px] uppercase tracking-[0.2em] text-slate-500">Terima kasih telah berbelanja di Ruaya Space</p>
        </div>
    </div>
</div>
@endsection
