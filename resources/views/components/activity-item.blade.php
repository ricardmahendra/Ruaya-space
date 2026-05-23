<div class="flex items-start gap-4 rounded-3xl border border-slate-200 bg-white p-4 shadow-sm">
    <div class="rounded-2xl bg-slate-50 p-3 text-slate-600">{{ $icon ?? '📝' }}</div>
    <div class="min-w-0">
        <div class="text-sm font-semibold text-slate-900">{{ $title }}</div>
        <div class="text-sm text-slate-500">{{ $slot }}</div>
        @isset($time)
            <div class="mt-2 text-xs uppercase tracking-[0.2em] text-slate-400">{{ $time }}</div>
        @endisset
    </div>
</div>
