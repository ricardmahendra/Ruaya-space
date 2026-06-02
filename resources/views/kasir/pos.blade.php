@extends('layouts.app')

@section('content')
<div class="bg-slate-50 min-h-screen p-6">
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-slate-900">Point of Sale</h1>
                <p class="text-slate-500 mt-1">Tambah item ke transaksi dan proses pembayaran di kasir.</p>
            </div>
            <a href="{{ route('kasir.dashboard') }}" class="bg-slate-100 text-slate-700 px-5 py-3 rounded-2xl font-semibold hover:bg-slate-200">Kembali ke Dashboard</a>
        </div>

        <!-- Main Layout -->
        <div class="flex gap-6">
            <!-- Menu Produk (Left) -->
            <div class="flex-1 min-w-0">
                <div class="bg-white rounded-3xl border border-slate-200 p-6 h-full">
                    <h2 class="text-lg font-semibold text-slate-900 mb-2">Menu Produk</h2>
                    <p class="text-sm text-slate-500 mb-4">Pilih produk untuk ditambahkan ke transaksi.</p>

                    <!-- Search -->
                    <form method="GET" action="{{ url()->current() }}" class="mb-4">
                        <input
                            type="search"
                            name="search"
                            value="{{ request('search') }}"
                            placeholder="Cari nama produk..."
                            class="w-full px-4 py-2 rounded-2xl border border-slate-200 text-sm focus:outline-none focus:border-slate-400"
                        />
                    </form>

                    <!-- Grid Produk -->
                    <div class="overflow-y-auto" style="height: calc(100vh - 300px);">
                        <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px;">
                            @forelse($menus as $menu)
                                <form action="{{ route('kasir.pos.add') }}" method="POST" class="bg-white border border-slate-200 rounded-lg p-2 hover:shadow-md transition h-36 flex flex-col justify-between">
                                    @csrf
                                    <input type="hidden" name="menu_id" value="{{ $menu->id }}" />
                                    
                                    <!-- Image -->
                                    <div class="w-30 h-30 bg-slate-100 rounded-lg overflow-hidden mb-2">
                                        @if($menu->gambar)
                                            <img src="{{ asset('storage/' . $menu->gambar) }}" alt="{{ $menu->nama_menu }}" class="w-full h-full object-cover" />
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-400 text-xs">No Image</div>
                                        @endif
                                    </div>

                                    <!-- Info -->
                                    <div class="mb-1">
                                        <h3 class="text-xs font-semibold text-slate-900 line-clamp-1">{{ $menu->nama_menu }}</h3>
                                        <p class="text-xs text-slate-500">Rp{{ number_format($menu->harga, 0, ',', '.') }}</p>
                                    </div>

                                    <!-- Qty & Button -->
                                    <div class="flex gap-1 items-center">
                                        <input type="number" name="qty" min="1" value="1" class="w-10 px-1 py-1 text-xs border border-slate-200 rounded" />
                                        <button type="submit" class="flex-1 bg-slate-900 text-white text-xs font-semibold py-1 rounded hover:bg-slate-800">Tambah</button>
                                    </div>
                                </form>
                            @empty
                                <div style="grid-column: 1 / -1;" class="text-center py-8 text-slate-400">
                                    <p>Tidak ada menu tersedia</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Checkout Panel (Right) -->
            <div class="w-80 sticky top-6 h-fit">
                <div class="bg-white rounded-3xl border border-slate-200 p-6 shadow-sm">
                    <h2 class="text-lg font-semibold text-slate-900 mb-4">Keranjang</h2>

                    <!-- Cart Items -->
                    <div class="max-h-64 overflow-y-auto border-b border-slate-200 pb-4 mb-4">
                        @if(!empty($cartItems))
                            <div class="space-y-3">
                                @foreach($cartItems as $item)
                                    <div class="bg-slate-50 p-3 rounded-xl">
                                        <div class="flex justify-between items-start mb-2">
                                            <div class="flex-1">
                                                <p class="text-sm font-semibold text-slate-900">{{ $item['nama_menu'] }}</p>
                                                <p class="text-xs text-slate-500">Rp{{ number_format($item['harga'], 0, ',', '.') }}</p>
                                            </div>
                                            <form action="{{ route('kasir.pos.remove', ['menu' => $item['menu_id']]) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs text-red-600 font-semibold hover:text-red-700">Hapus</button>
                                            </form>
                                        </div>

                                        <!-- Qty Controls -->
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-1">
                                                <form action="{{ route('kasir.pos.update', ['menu' => $item['menu_id']]) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="qty" value="{{ $item['qty'] - 1 }}">
                                                    <button type="submit" @if($item['qty'] <= 1) disabled @endif class="px-2 py-0.5 bg-slate-200 text-slate-700 text-xs font-bold rounded hover:bg-slate-300 disabled:opacity-50">−</button>
                                                </form>
                                                <span class="w-6 text-center text-sm font-semibold">{{ $item['qty'] }}</span>
                                                <form action="{{ route('kasir.pos.update', ['menu' => $item['menu_id']]) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="qty" value="{{ $item['qty'] + 1 }}">
                                                    <button type="submit" class="px-2 py-0.5 bg-slate-200 text-slate-700 text-xs font-bold rounded hover:bg-slate-300">+</button>
                                                </form>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-xs text-slate-500">Total</p>
                                                <p class="text-sm font-bold text-slate-900">Rp{{ number_format($item['subtotal'], 0, ',', '.') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-6 text-slate-400">
                                <p class="text-sm">Keranjang kosong</p>
                            </div>
                        @endif
                    </div>

                    <!-- Summary -->
                    <div class="bg-slate-50 p-4 rounded-2xl mb-4">
                        <div class="flex justify-between mb-2">
                            <span class="text-sm text-slate-600">Total Item</span>
                            <span class="text-sm font-bold text-slate-900">{{ $cartCount }}</span>
                        </div>
                        <div class="flex justify-between border-t border-slate-200 pt-2">
                            <span class="text-sm text-slate-600">Subtotal</span>
                            <span class="text-sm font-bold text-slate-900">Rp{{ number_format($cartTotal, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Checkout Form -->
                    <form action="{{ route('kasir.pos.checkout') }}" method="POST" class="space-y-3">
                        @csrf
                        
                        <div>
                            <label class="text-xs font-semibold text-slate-700 block mb-1">Total Bayar</label>
                            <input type="number" name="bayar" min="0" step="100" value="{{ old('bayar') }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm" required />
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-slate-700 block mb-1">Metode Bayar</label>
                            <select name="metode_bayar" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm" required>
                                <option value="tunai">Tunai</option>
                                <option value="transfer">Transfer</option>
                                <option value="kartu">Kartu</option>
                            </select>
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-slate-700 block mb-1">Catatan</label>
                            <input type="text" name="catatan" value="{{ old('catatan') }}" class="w-full px-3 py-2 border border-slate-200 rounded-lg text-sm" placeholder="Opsional" />
                        </div>

                        <button type="submit" class="w-full bg-slate-900 text-white font-semibold py-2.5 rounded-2xl hover:bg-slate-800 mt-4">Proses Pembayaran</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
