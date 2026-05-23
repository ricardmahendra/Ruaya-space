@php
    $status = $status ?? 'aman';
@endphp

@if($status === 'aman')
    <span class="inline-flex rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-700">In Stock</span>
@elseif($status === 'menipis')
    <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">Low Stock</span>
@else
    <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">Out of Stock</span>
@endif
