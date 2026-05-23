@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-slate-900">Suppliers</h1>
            <p class="text-slate-500">Kelola supplier bahan untuk operasional cafe.</p>
        </div>
        <a href="{{ route('suppliers.create') }}" class="rounded-3xl border border-black bg-gradient-to-r from-amber-200 to-amber-400 px-5 py-3 text-sm font-medium text-black shadow-sm hover:from-amber-300 hover:to-amber-500 transition">Tambah Supplier</a>
    </div>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <table class="w-full text-left text-sm text-slate-700">
            <thead class="bg-slate-50 text-slate-500">
                <tr>
                    <th class="px-6 py-4">Nama Supplier</th>
                    <th class="px-6 py-4">Kontak</th>
                    <th class="px-6 py-4">Email</th>
                    <th class="px-6 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach($suppliers as $supplier)
                <tr>
                    <td class="px-6 py-4">{{ $supplier->nama_supplier }}</td>
                    <td class="px-6 py-4">{{ $supplier->kontak ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $supplier->email ?? '-' }}</td>
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('suppliers.edit', $supplier) }}" class="inline-flex items-center gap-1 rounded-full bg-amber-500 px-4 py-2 text-xs font-semibold text-white shadow-sm hover:bg-amber-600 transition-colors">✏️ Edit</a>
                            <form action="{{ route('suppliers.destroy', $supplier) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus supplier ini?')" class="inline-flex items-center gap-1 rounded-full bg-red-600 px-4 py-2 text-xs font-semibold text-white shadow-sm hover:bg-red-700 transition-colors">🗑️ Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @include('components.pagination', ['paginator' => $suppliers])
</div>
@endsection
