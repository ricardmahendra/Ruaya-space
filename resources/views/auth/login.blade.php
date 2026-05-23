@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-[#1a3a2a] px-4 py-10">
    <div class="relative flex w-full max-w-4xl overflow-hidden rounded-[2rem] bg-white shadow-2xl">
        <div class="hidden lg:block w-1/2 bg-[#1a3a2a] p-14 text-white">
            <div class="absolute left-0 top-0 h-full w-10 bg-white/10"></div>
            <div class="flex h-full flex-col justify-between">
                <div class="text-7xl font-black opacity-10">CAFE</div>
                <div class="space-y-6">
                    <div class="text-4xl font-bold">Ruaya Space</div>
                    <p class="max-w-xs text-sm text-slate-200">Manage your atelier experience with smart inventory control and FIFO supply tracking.</p>
                </div>
                <div class="text-xs uppercase tracking-[0.3em] text-slate-400">COFFEE ATELIER</div>
            </div>
        </div>
        <div class="w-full lg:w-1/2 p-10">
            <div class="mb-8 space-y-4">
                <div class="flex h-14 w-14 items-center justify-center rounded-3xl bg-slate-100 text-2xl text-emerald-700">☕</div>
                <div>
                    <h1 class="text-3xl font-semibold text-slate-900">Ruaya Space</h1>
                    <p class="text-sm text-slate-500">Login untuk mengakses dashboard manajemen stok.</p>
                </div>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="text-sm font-medium text-slate-700">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required autofocus class="mt-2 w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 focus:border-emerald-600 focus:outline-none" />
                    @error('email')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="text-sm font-medium text-slate-700">Password</label>
                    <div class="relative mt-2">
                        <input id="password" type="password" name="password" required class="w-full rounded-3xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-800 focus:border-emerald-600 focus:outline-none" />
                        <button type="button" onclick="togglePassword()" class="absolute inset-y-0 right-4 inline-flex items-center text-slate-500">Show</button>
                    </div>
                    @error('password')<p class="mt-2 text-sm text-red-600">{{ $message }}</p>@enderror
                </div>
                <div class="flex items-center justify-between text-sm text-slate-500">
                    <label class="inline-flex items-center gap-2"><input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-emerald-600" /> Remember me</label>
                    <a href="{{ route('password.request') }}" class="font-medium text-emerald-600 hover:text-emerald-700">Forgot Password?</a>
                </div>
                <button type="submit" class="w-full rounded-3xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white hover:bg-slate-800">Login →</button>
            </form>
            <p class="mt-6 text-center text-sm text-slate-500">Need administrative access? Contact Operations</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function togglePassword() {
        const input = document.getElementById('password');
        input.type = input.type === 'password' ? 'text' : 'password';
    }
</script>
@endpush
