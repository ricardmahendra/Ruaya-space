<div>
    <!-- Mobile sidebar -->
    <aside x-cloak x-show="sidebarOpen" class="fixed inset-0 z-30 md:hidden">
        <div class="absolute inset-0 bg-black/40" @click="sidebarOpen = false"></div>
        <div class="relative w-72 h-full bg-white/90 glass border-r border-slate-200 shadow-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <div class="text-slate-900 font-bold text-lg">Ruaya Space</div>
                    <div class="text-xs text-slate-500 uppercase">COFFEE ATELIER</div>
                </div>
                <button @click="sidebarOpen = false" class="text-slate-600 hover:text-slate-900">✕</button>
            </div>
            <nav class="space-y-2">
                <a href="{{ route('dashboard') }}" class="block rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-brand-50 border-l-4 border-brand-500 text-slate-900' : 'text-slate-600 hover:bg-slate-50' }}">Dashboard</a>
                <a href="{{ route('barangs.index') }}" class="block rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('barangs.*') ? 'bg-brand-50 border-l-4 border-brand-500 text-slate-900' : 'text-slate-600 hover:bg-slate-50' }}">Inventory</a>

                @if(auth()->check() && auth()->user()->role === 'admin')
                    <a href="{{ route('kategoris.index') }}" class="block rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('kategoris.*') ? 'bg-brand-50 border-l-4 border-brand-500 text-slate-900' : 'text-slate-600 hover:bg-slate-50' }}">Kategori</a>
                    <a href="{{ route('suppliers.index') }}" class="block rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('suppliers.*') ? 'bg-brand-50 border-l-4 border-brand-500 text-slate-900' : 'text-slate-600 hover:bg-slate-50' }}">Supplier</a>
                @endif

                <a href="{{ route('stok-masuk.index') }}" class="block rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('stok-masuk.*') || request()->routeIs('stok-keluar.*') ? 'bg-brand-50 border-l-4 border-brand-500 text-slate-900' : 'text-slate-600 hover:bg-slate-50' }}">Operations</a>
                <a href="{{ route('laporan.stok') }}" class="block rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('laporan.*') ? 'bg-brand-50 border-l-4 border-brand-500 text-slate-900' : 'text-slate-600 hover:bg-slate-50' }}">Reports</a>
            </nav>

            <div class="mt-auto pt-6">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full btn-primary">Logout</button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Desktop sidebar -->
    <aside class="hidden md:block w-72 bg-white/60 glass border-r border-slate-200 min-h-screen sticky top-0">
        <div class="px-6 py-6">
            <div class="mb-8">
                <div class="text-slate-900 font-bold text-xl">Ruaya Space</div>
                <div class="text-sm text-slate-500 uppercase">COFFEE ATELIER</div>
            </div>
            <nav class="space-y-2">
                <a href="{{ route('dashboard') }}" class="block rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('dashboard') ? 'bg-brand-50 border-l-4 border-brand-500 text-slate-900' : 'text-slate-600 hover:bg-slate-50' }}">Dashboard</a>
                <a href="{{ route('barangs.index') }}" class="block rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('barangs.*') ? 'bg-brand-50 border-l-4 border-brand-500 text-slate-900' : 'text-slate-600 hover:bg-slate-50' }}">Inventory</a>

                @if(auth()->check() && auth()->user()->role === 'admin')
                    <a href="{{ route('kategoris.index') }}" class="block rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('kategoris.*') ? 'bg-brand-50 border-l-4 border-brand-500 text-slate-900' : 'text-slate-600 hover:bg-slate-50' }}">Kategori</a>
                    <a href="{{ route('suppliers.index') }}" class="block rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('suppliers.*') ? 'bg-brand-50 border-l-4 border-brand-500 text-slate-900' : 'text-slate-600 hover:bg-slate-50' }}">Supplier</a>
                @endif

                <a href="{{ route('stok-masuk.index') }}" class="block rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('stok-masuk.*') || request()->routeIs('stok-keluar.*') ? 'bg-brand-50 border-l-4 border-brand-500 text-slate-900' : 'text-slate-600 hover:bg-slate-50' }}">Operations</a>
                <a href="{{ route('laporan.stok') }}" class="block rounded-xl px-4 py-3 text-sm font-medium {{ request()->routeIs('laporan.*') ? 'bg-brand-50 border-l-4 border-brand-500 text-slate-900' : 'text-slate-600 hover:bg-slate-50' }}">Reports</a>
            </nav>
        </div>

        <div class="mt-auto px-6 py-6">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full btn-primary">Logout</button>
            </form>
        </div>
    </aside>
</div>
