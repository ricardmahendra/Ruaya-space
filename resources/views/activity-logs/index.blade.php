@extends('layouts.app')

@section('content')
<div class="space-y-6">
    <div class="rounded-3xl bg-white p-8 shadow-sm">
        <div class="flex flex-col gap-3 md:flex-row md:items-end md:justify-between">
            <div>
                <h1 class="text-3xl font-semibold text-slate-900">Activity Logs</h1>
                <p class="text-slate-500">Semua aktivitas terbaru di sistem.</p>
            </div>
            <a href="{{ route('dashboard') }}" class="rounded-3xl bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-200">Kembali ke Dashboard</a>
        </div>
    </div>

    <div class="rounded-3xl bg-white p-8 shadow-sm">
        <div class="space-y-4">
            @forelse($activities as $activity)
                @component('components.activity-item', ['title' => $activity->action, 'icon' => '📌', 'time' => $activity->created_at->diffForHumans()])
                    {{ $activity->deskripsi }}
                @endcomponent
            @empty
                <div class="rounded-3xl border border-slate-200 bg-slate-50 p-6 text-sm text-slate-500">Belum ada aktivitas.</div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $activities->links() }}
        </div>
    </div>
</div>
@endsection
