@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-slate-900">Kategori</h1>
            <p class="text-slate-500">Kelola kategori barang Ruaya Space Coffee.</p>
        </div>
        <a href="{{ route('kategoris.create') }}" class="rounded-3xl border border-black bg-gradient-to-r from-amber-200 to-amber-400 px-5 py-3 text-sm font-medium text-black shadow-sm hover:from-amber-300 hover:to-amber-500 transition">Tambah Kategori</a>
    </div>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <table class="w-full text-left text-sm text-slate-700">
            <thead class="bg-slate-50 text-slate-500">
                <tr>
                    <th class="px-6 py-4">Nama Kategori</th>
                    <th class="px-6 py-4">Slug</th>
                    <th class="px-6 py-4">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach($kategoris as $kategori)
                <tr>
                    <td class="px-6 py-4">{{ $kategori->nama_kategori }}</td>
                    <td class="px-6 py-4">{{ $kategori->slug }}</td>
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-2">
                            <a href="{{ route('kategoris.edit', $kategori) }}" class="inline-flex items-center gap-1 rounded-full bg-amber-500 px-4 py-2 text-xs font-semibold text-white shadow-sm hover:bg-amber-600 transition-colors">✏️ Edit</a>
                            <form action="{{ route('kategoris.destroy', $kategori) }}" method="POST" class="inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" onclick="return confirm('Yakin ingin menghapus kategori ini?')" class="inline-flex items-center gap-1 rounded-full bg-red-600 px-4 py-2 text-xs font-semibold text-white shadow-sm hover:bg-red-700 transition-colors">🗑️ Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @include('components.pagination', ['paginator' => $kategoris])
</div>
@endsection
