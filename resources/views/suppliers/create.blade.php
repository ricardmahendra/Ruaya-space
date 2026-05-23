@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-slate-900">Tambah Supplier</h1>
            <p class="text-slate-500">Tambahkan data supplier baru untuk bahan baku.</p>
        </div>
        <a href="{{ route('suppliers.index') }}" class="rounded-3xl bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-200">Kembali</a>
    </div>

    <div class="rounded-3xl bg-white p-8 shadow-sm">
        <form action="{{ route('suppliers.store') }}" method="POST" class="grid gap-6">
            @csrf
            <div>
                <label class="text-sm font-medium text-slate-700">Nama Supplier</label>
                <input name="nama_supplier" value="{{ old('nama_supplier') }}" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700" required />
            </div>
            <div>
                <label class="text-sm font-medium text-slate-700">Kontak</label>
                <input name="kontak" value="{{ old('kontak') }}" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700" />
            </div>
            <div>
                <label class="text-sm font-medium text-slate-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700" />
            </div>
            <div>
                <label class="text-sm font-medium text-slate-700">Alamat</label>
                <textarea name="alamat" rows="4" class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700">{{ old('alamat') }}</textarea>
            </div>
            <button type="submit" class="rounded-3xl border border-black bg-gradient-to-r from-slate-400 via-slate-600 to-slate-900 px-6 py-3 text-sm font-medium text-black shadow-md hover:from-slate-500 hover:via-slate-700 hover:to-black transition">Simpan Supplier</button>
        </form>
    </div>
</div>
@endsection
