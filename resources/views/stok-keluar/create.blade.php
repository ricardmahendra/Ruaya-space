@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-slate-900">Tambah Stok Keluar</h1>
            <p class="text-slate-500">Input pengeluaran barang dari gudang.</p>
        </div>
        <a href="{{ route('stok-keluar.index') }}" class="rounded-3xl bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-200">Kembali</a>
    </div>

    <div class="rounded-3xl bg-white p-8 shadow-sm">
        <form action="{{ route('stok-keluar.store') }}" method="POST" class="grid gap-6">
            @csrf
            <div>
                <label class="text-sm font-medium text-slate-700">Nama Barang</label>
                <select name="barang_id" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700" required>
                    <option value="">Pilih barang</option>
                    @foreach($barangs as $barang)
                        <option value="{{ $barang->id }}" {{ old('barang_id', request('barang_id')) == $barang->id ? 'selected' : '' }}>{{ $barang->nama_barang }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="text-sm font-medium text-slate-700">Jumlah Keluar</label>
                <input type="number" name="jumlah" min="1" value="{{ old('jumlah') }}" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700" required />
            </div>
            <div>
                <label class="text-sm font-medium text-slate-700">Tanggal Keluar</label>
                <input type="date" name="tanggal_keluar" value="{{ old('tanggal_keluar', now()->format('Y-m-d')) }}" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700" required />
            </div>
            <div>
                <label class="text-sm font-medium text-slate-700">Tujuan Pengeluaran</label>
                <input name="tujuan_penggunaan" value="{{ old('tujuan_penggunaan') }}" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700" placeholder="Contoh: Dapur, Bar, Penjualan" required />
            </div>
            <button type="submit" class="rounded-3xl border border-black bg-gradient-to-r from-slate-400 via-slate-600 to-slate-900 px-6 py-3 text-sm font-medium text-black shadow-md hover:from-slate-500 hover:via-slate-700 hover:to-black transition">Simpan Stok Keluar</button>
        </form>
    </div>
</div>
@endsection
