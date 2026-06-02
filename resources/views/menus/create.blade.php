@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-slate-900">Tambah Menu Baru</h1>
            <p class="text-slate-500">Buat menu baru agar bisa dijual di kasir.</p>
        </div>
        <a href="{{ route('menus.index') }}" class="rounded-3xl bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-200">Kembali</a>
    </div>

    <div class="rounded-3xl bg-white p-8 shadow-sm">
        <form action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data" class="grid gap-6">
            @csrf
            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label class="text-sm font-medium text-slate-700">Kode Menu</label>
                    <input name="kode_menu" value="{{ old('kode_menu') }}" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700" required />
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-700">Nama Menu</label>
                    <input name="nama_menu" value="{{ old('nama_menu') }}" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700" required />
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label class="text-sm font-medium text-slate-700">Harga</label>
                    <input type="number" step="0.01" name="harga" value="{{ old('harga') }}" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700" required />
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-700">Gambar Menu</label>
                    <input type="file" name="gambar" accept="image/*" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700" />
                </div>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                <div>
                    <label class="text-sm font-medium text-slate-700">Status Aktif</label>
                    <div class="mt-2">
                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" name="is_available" value="1" class="rounded border-slate-300 text-slate-900 shadow-sm focus:ring-slate-500" checked>
                            <span class="text-sm text-slate-700">Menu aktif</span>
                        </label>
                    </div>
                </div>
            </div>

            <div>
                <label class="text-sm font-medium text-slate-700">Deskripsi</label>
                <textarea name="deskripsi" rows="4" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700">{{ old('deskripsi') }}</textarea>
            </div>

            <button type="submit" class="rounded-3xl border border-black bg-gradient-to-r from-slate-400 via-slate-600 to-slate-900 px-6 py-3 text-sm font-medium text-black shadow-md hover:from-slate-500 hover:via-slate-700 hover:to-black transition">Simpan Menu</button>
        </form>
    </div>
</div>
@endsection
