<header class="bg-white/60 glass px-4 sm:px-6 py-3 border-b border-slate-200 sticky top-0 z-20">
    <div class="max-w-screen-xl mx-auto flex items-center justify-between gap-4">
        <div class="flex items-center gap-3">
            <button @click="sidebarOpen = !sidebarOpen" class="md:hidden p-2 rounded-lg text-slate-600 hover:bg-slate-100">☰</button>
            <div class="hidden sm:block text-slate-500 text-sm">Search orders, stock or members...</div>
            <div class="relative w-full max-w-lg">
                <input type="text" placeholder="Search orders, stock or members..." class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-2 text-sm text-slate-700 focus:border-brand-500 focus:ring-1 focus:ring-brand-100 focus:outline-none" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <button class="p-2 rounded-lg text-slate-600 hover:bg-slate-100">🔔</button>
            <button class="p-2 rounded-lg text-slate-600 hover:bg-slate-100">⚙️</button>
            <div class="flex items-center gap-3 rounded-2xl bg-white px-4 py-2 shadow-md-soft">
                <div class="h-10 w-10 rounded-full bg-brand-500 flex items-center justify-center text-white font-bold">{{ strtoupper(substr(auth()->user()?->name, 0, 1)) }}</div>
                <div class="text-sm">
                    <div class="font-semibold">{{ auth()->user()?->name }}</div>
                    <div class="text-slate-500">{{ strtoupper(auth()->user()?->role) }}</div>
                </div>
            </div>
        </div>
    </div>
</header>
