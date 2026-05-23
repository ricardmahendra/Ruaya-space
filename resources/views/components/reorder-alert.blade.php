@php
    $alertReorder = \App\Models\Barang::whereColumn('stok', '<=', 'reorder_point')->count();
@endphp

@if($alertReorder > 0)
    <div class="mb-6 rounded-3xl border border-red-200 bg-red-50 px-6 py-4 text-sm text-red-700">
        <div class="font-semibold">INVENTORY ALERT</div>
        <div>{{ $alertReorder }} item perlu perhatian karena berada di atau di bawah Reorder Point.</div>
    </div>
@endif
