@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-slate-900">Tambah Stok Masuk</h1>
            <p class="text-slate-500">Catat setiap batch barang yang masuk ke gudang.</p>
        </div>
        <a href="{{ route('stok-masuk.index') }}" class="rounded-3xl bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-200">Lihat Riwayat</a>
    </div>

    <div class="rounded-3xl bg-white p-8 shadow-sm">
        <form action="{{ route('stok-masuk.store') }}" method="POST" class="grid gap-6">
            @csrf
            <div>
                <label class="text-sm font-medium text-slate-700">Nama Barang</label>
                <select name="barang_id" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700" required>
                    <option value="">Pilih barang</option>
                    @foreach($barangs as $barang)
                        <option value="{{ $barang->id }}">{{ $barang->nama_barang }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-sm font-medium text-slate-700">Supplier</label>
                <select name="supplier_id" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700">
                    <option value="">Pilih supplier</option>
                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">{{ $supplier->nama_supplier }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-sm font-medium text-slate-700">Jumlah Masuk</label>
                <input type="number" name="jumlah" min="1" value="{{ old('jumlah') }}" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700" required />
            </div>
            <div>
                <label class="text-sm font-medium text-slate-700">Tanggal Masuk</label>
                <input type="date" name="tanggal_masuk" value="{{ old('tanggal_masuk', now()->format('Y-m-d')) }}" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700" required />
            </div>
            <div>
                <label class="text-sm font-medium text-slate-700">Batch Code</label>
                <input name="batch_code" value="{{ old('batch_code') }}" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700" />
            </div>
            <button type="submit" class="rounded-3xl border border-black bg-gradient-to-r from-slate-400 via-slate-600 to-slate-900 px-6 py-3 text-sm font-medium text-black shadow-md hover:from-slate-500 hover:via-slate-700 hover:to-black transition">Simpan Stok Masuk</button>
        </form>
    </div>
</div>
@endsection
