@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-slate-900">Stok Masuk</h1>
            <p class="text-slate-500">Rekam setiap batch barang yang masuk ke gudang.</p>
        </div>
        <a href="{{ route('stok-masuk.create') }}" class="rounded-3xl border border-black bg-gradient-to-r from-amber-200 to-amber-400 px-5 py-3 text-sm font-medium text-black shadow-sm hover:from-amber-300 hover:to-amber-500 transition">Tambah Stok Masuk</a>
    </div>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <table class="w-full text-left text-sm text-slate-700">
            <thead class="bg-slate-50 text-slate-500">
                <tr>
                    <th class="px-6 py-4">Tanggal</th>
                    <th class="px-6 py-4">Item</th>
                    <th class="px-6 py-4">Supplier</th>
                    <th class="px-6 py-4">Jumlah</th>
                    <th class="px-6 py-4">Batch</th>
                    <th class="px-6 py-4">User</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach($stokMasuks as $item)
                <tr>
                    <td class="px-6 py-4">{{ $item->tanggal_masuk->format('Y-m-d') }}</td>
                    <td class="px-6 py-4">{{ $item->barang->nama_barang ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $item->supplier?->nama_supplier ?? 'Internal' }}</td>
                    <td class="px-6 py-4">{{ $item->jumlah }} {{ $item->barang?->satuan }}</td>
                    <td class="px-6 py-4">{{ $item->batch_code }}</td>
                    <td class="px-6 py-4">{{ $item->user->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @include('components.pagination', ['paginator' => $stokMasuks])
</div>
@endsection
