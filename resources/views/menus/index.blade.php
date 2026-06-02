@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-semibold text-slate-900">Master Menu</h1>
            <p class="text-slate-500">Kelola menu yang dijual oleh kasir.</p>
        </div>
        <a href="{{ route('menus.create') }}" class="rounded-3xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white hover:bg-slate-800">Tambah Menu</a>
    </div>

    <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
        <table class="w-full text-sm text-slate-700">
            <thead class="bg-slate-100 border-b border-slate-200">
                <tr>
                    <th class="px-6 py-3 text-left font-semibold">Gambar</th>
                    <th class="px-6 py-3 text-left font-semibold">Kode</th>
                    <th class="px-6 py-3 text-left font-semibold">Nama Menu</th>
                    <th class="px-6 py-3 text-right font-semibold">Harga</th>
                    <th class="px-6 py-3 text-center font-semibold">Status</th>
                    <th class="px-6 py-3 text-right font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-200">
                @forelse($menus as $menu)
                <tr class="hover:bg-slate-50">
                    <td class="px-6 py-4">
                        @if($menu->gambar)
                            <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama_menu }}" class="h-12 w-12 rounded-2xl object-cover" />
                        @else
                            <div class="h-12 w-12 rounded-2xl bg-slate-100 flex items-center justify-center text-slate-400 text-xs">−</div>
                        @endif
                    </td>
                    <td class="px-6 py-4">{{ $menu->kode_menu }}</td>
                    <td class="px-6 py-4">{{ $menu->nama_menu }}</td>
                    <td class="px-6 py-4 text-right">Rp{{ number_format($menu->harga, 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex rounded-full px-3 py-1 text-xs font-semibold {{ $menu->is_available ? 'bg-emerald-100 text-emerald-700' : 'bg-slate-100 text-slate-600' }}">
                            {{ $menu->is_available ? 'Aktif' : 'Tidak Aktif' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('menu-recipes.index', ['menu_id' => $menu->id]) }}" class="rounded-2xl bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-200">Resep</a>
                        <a href="{{ route('menus.edit', $menu) }}" class="rounded-2xl bg-slate-100 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-200">Edit</a>
                        <form action="{{ route('menus.destroy', $menu) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus menu ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-2xl bg-red-100 px-3 py-2 text-xs font-semibold text-red-700 hover:bg-red-200">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center text-slate-500">Belum ada menu.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $menus->links() }}
</div>
@endsection
