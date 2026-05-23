@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div>
        <h1 class="text-3xl font-semibold text-slate-900">Inventory Management</h1>
        <p class="text-slate-500 mb-6">Pantau semua barang dan status stok Ruaya Space Coffee.</p>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div class="flex flex-wrap gap-3">
            <a href="{{ route('barangs.create') }}" class="inline-flex items-center rounded-3xl border border-black bg-gradient-to-r from-amber-200 to-amber-400 px-6 py-3 text-sm font-medium text-black shadow-md hover:from-amber-300 hover:to-amber-500 transition">Tambah Barang</a>
            <a href="{{ route('barangs.index', array_merge(request()->all(), ['export' => 1])) }}" class="inline-flex items-center gap-2 rounded-3xl bg-blue-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-blue-700 transition">📥 Export CSV</a>
        </div>
    </div>

    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
        <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="text-sm uppercase tracking-[0.2em] text-slate-400">Total Stock Items</div>
            <div class="mt-3 text-2xl font-semibold text-slate-900">{{ number_format($barangs->total()) }}</div>
        </div>
        <div class="rounded-3xl border border-amber-100 bg-amber-50 p-5 shadow-sm">
            <div class="text-sm uppercase tracking-[0.2em] text-amber-700">Low Stock Alerts</div>
            <div class="mt-3 text-2xl font-semibold text-slate-900">{{ number_format($barangs->where('status_stok', 'menipis')->count()) }}</div>
        </div>
        <div class="rounded-3xl border border-red-100 bg-red-50 p-5 shadow-sm">
            <div class="text-sm uppercase tracking-[0.2em] text-red-700">Out of Stock</div>
            <div class="mt-3 text-2xl font-semibold text-slate-900">{{ number_format($barangs->where('status_stok', 'habis')->count()) }}</div>
        </div>
        <div class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="text-sm uppercase tracking-[0.2em] text-slate-400">Next Delivery</div>
            <div class="mt-3 text-2xl font-semibold text-slate-900">3 Items</div>
        </div>
    </div>

    <div class="rounded-3xl bg-white p-6 shadow-sm">
        <form method="GET" class="grid gap-4 md:grid-cols-[1.2fr_0.8fr_0.6fr]">
            <input type="text" name="search" placeholder="Cari barang..." value="{{ request('search') }}" class="rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 focus:border-emerald-600 focus:outline-none" />
            <select name="kategori" class="rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 focus:border-emerald-600 focus:outline-none">
                <option value="">All Categories</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ request('kategori') == $kategori->id ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>
                @endforeach
            </select>
            <button type="submit" class="rounded-3xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">Filter</button>
        </form>
    </div>

    @if($barangs->count())
    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <table class="w-full text-left text-sm text-slate-700">
            <thead class="bg-slate-50 text-slate-500">
                <tr>
                    <th class="px-6 py-4">Item Name</th>
                    <th class="px-6 py-4">Category</th>
                    <th class="px-6 py-4">Stock</th>
                    <th class="px-6 py-4">Unit</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @foreach($barangs as $barang)
                <tr>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="h-12 w-12 rounded-3xl bg-slate-100 flex items-center justify-center text-slate-500">{{ strtoupper(substr($barang->nama_barang, 0, 1)) }}</div>
                            <div>
                                <div class="font-semibold text-slate-900">{{ $barang->nama_barang }}</div>
                                <div class="text-xs text-slate-500">{{ $barang->deskripsi ? Str::limit($barang->deskripsi, 50) : 'Tidak ada deskripsi' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">{{ $barang->kategori->nama_kategori }}</td>
                    <td class="px-6 py-4">{{ $barang->stok }}</td>
                    <td class="px-6 py-4">{{ $barang->satuan }}</td>
                    <td class="px-6 py-4">@include('components.stock-badge', ['status' => $barang->status_stok])</td>
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('barangs.detail', $barang) }}" class="inline-flex items-center gap-1 rounded-full bg-blue-600 px-4 py-2 text-xs font-semibold text-white shadow-sm hover:bg-blue-700 transition-colors">👁️ Lihat</a>
                                    <a href="{{ route('barangs.edit', $barang) }}" class="inline-flex items-center gap-1 rounded-full bg-amber-500 px-4 py-2 text-xs font-semibold text-white shadow-sm hover:bg-amber-600 transition-colors">✏️ Ubah</a>
                                    <form action="{{ route('barangs.destroy', $barang) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin ingin menghapus barang ini?')" class="inline-flex items-center gap-1 rounded-full bg-red-600 px-4 py-2 text-xs font-semibold text-white shadow-sm hover:bg-red-700 transition-colors">🗑️ Hapus</button>
                                    </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="rounded-3xl border border-dashed border-slate-300 bg-slate-50 p-10 text-center text-slate-600 shadow-sm">
        <div class="text-xl font-semibold text-slate-900">Belum ada data barang</div>
        <p class="mt-3 text-sm">Klik tombol <strong>Tambah Barang</strong> untuk menambahkan stok pertama Anda.</p>
        <a href="{{ route('barangs.create') }}" class="mt-5 inline-flex rounded-3xl border border-black bg-gradient-to-r from-amber-200 to-amber-400 px-6 py-3 text-sm font-medium text-black shadow-sm hover:from-amber-300 hover:to-amber-500 transition">Tambah Barang</a>
    </div>
    @endif

    @include('components.pagination', ['paginator' => $barangs])
</div>
@endsection
