@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-slate-900">Tambah Barang Baru</h1>
            <p class="text-slate-500">Isi data lengkap untuk barang baru di inventory.</p>
        </div>
        <a href="{{ route('barangs.index') }}" class="rounded-3xl bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-200">Kembali</a>
    </div>

    <div class="rounded-3xl bg-white p-8 shadow-sm">
        <form action="{{ route('barangs.store') }}" method="POST" enctype="multipart/form-data" class="grid gap-6">
            @csrf
            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label class="text-sm font-medium text-slate-700">Kode Barang</label>
                    <input name="kode_barang" value="{{ old('kode_barang') }}" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700" required />
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-700">Nama Barang</label>
                    <input name="nama_barang" value="{{ old('nama_barang') }}" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700" required />
                </div>
            </div>
            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label class="text-sm font-medium text-slate-700">Kategori</label>
                    <select name="kategori_id" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700" required>
                        <option value="">Pilih kategori</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-700">Satuan</label>
                    <input name="satuan" value="{{ old('satuan') }}" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700" required />
                </div>
            </div>
            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label class="text-sm font-medium text-slate-700">Stok Minimal</label>
                    <input type="number" name="stok_minimal" value="{{ old('stok_minimal', 0) }}" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700" required />
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-700">Harga Beli</label>
                    <input type="number" step="0.01" name="harga_beli" value="{{ old('harga_beli', 0) }}" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700" required />
                </div>
            </div>
            <div class="grid gap-6 md:grid-cols-3">
                <div>
                    <label class="text-sm font-medium text-slate-700">Average Usage</label>
                    <input type="number" name="average_usage" value="{{ old('average_usage', 0) }}" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700" required />
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-700">Lead Time</label>
                    <input type="number" name="lead_time" value="{{ old('lead_time', 1) }}" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700" required />
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-700">Safety Stock</label>
                    <input type="number" name="safety_stock" value="{{ old('safety_stock', 0) }}" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700" required />
                </div>
            </div>
            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label class="text-sm font-medium text-slate-700">Tanggal Expired</label>
                    <input type="date" name="tanggal_expired" value="{{ old('tanggal_expired') }}" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700" />
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-700">Lokasi Rak</label>
                    <input name="lokasi_rak" value="{{ old('lokasi_rak') }}" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700" />
                </div>
            </div>
            <div>
                <label class="text-sm font-medium text-slate-700">Gambar Barang</label>
                <input type="file" name="gambar" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700" />
            </div>
            <div>
                <label class="text-sm font-medium text-slate-700">Deskripsi</label>
                <textarea name="deskripsi" rows="4" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700">{{ old('deskripsi') }}</textarea>
            </div>
            <button type="submit" class="rounded-3xl border border-black bg-gradient-to-r from-slate-400 via-slate-600 to-slate-900 px-6 py-3 text-sm font-medium text-black shadow-md hover:from-slate-500 hover:via-slate-700 hover:to-black transition">Simpan Barang</button>
        </form>
    </div>
</div>
@endsection
