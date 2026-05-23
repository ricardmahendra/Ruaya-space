<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-white border border-slate-200 rounded-2xl font-medium text-sm text-slate-700 shadow-sm hover:bg-slate-50 focus:outline-none transition']) }}>
    {{ $slot }}
</button>
