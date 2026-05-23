@if ($paginator->hasPages())
    <div class="mt-6 flex items-center justify-between text-sm text-slate-600">
        <div>Showing {{ $paginator->firstItem() }}-{{ $paginator->lastItem() }} of {{ $paginator->total() }} items</div>
        <div class="inline-flex items-center gap-2">
            @if ($paginator->onFirstPage())
                <span class="inline-flex items-center rounded-full bg-slate-200 px-3 py-2">Previous</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex items-center rounded-full bg-emerald-600 px-3 py-2 text-white shadow-sm hover:bg-emerald-700">Previous</a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex items-center rounded-full bg-emerald-600 px-3 py-2 text-white shadow-sm hover:bg-emerald-700">Next</a>
            @else
                <span class="inline-flex items-center rounded-full bg-slate-200 px-3 py-2">Next</span>
            @endif
        </div>
    </div>
@endif
