@extends('layouts.app', ['title' => 'Verifikasi OTP'])

@section('content')
<div class="max-w-md mx-auto px-4 py-12 sm:py-16">
    <div class="starline-card p-6 sm:p-8 bg-white/95 backdrop-blur-xl border border-slate-200/90 shadow-sm rounded-3xl">
        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-[#0f172a] text-[#e6ff94] mb-3 shadow-xs">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 font-display tracking-tight">Verifikasi Kode</h1>
            <p class="text-xs text-slate-500 mt-1 font-sans">
                Masukkan 6 digit kode yang dikirim ke <span class="font-bold text-slate-700">{{ $email }}</span>
            </p>
        </div>

        @if(session('error'))
            <div class="mb-5 p-3 rounded-xl bg-rose-50 border border-rose-200 text-xs text-rose-700 font-medium">
                {{ session('error') }}
            </div>
        @endif

        @if(session('success'))
            <div class="mb-5 p-3 rounded-xl bg-emerald-50 border border-emerald-200 text-xs text-emerald-800 font-medium">
                {{ session('success') }}
            </div>
        @endif

        @if(session('dev_otp'))
            <div class="mb-5 p-3 rounded-xl bg-[#e6ff94]/60 border border-[#c2e050] text-xs text-slate-900 font-mono">
                [LOKAL DEBUG] Kode OTP Anda: <strong>{{ session('dev_otp') }}</strong>
            </div>
        @endif

        <form action="{{ route('auth.otp.check') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="email" value="{{ $email }}">

            <div>
                <label for="otp" class="block text-xs font-bold text-slate-700 mb-1 text-center">Kode 6 Digit</label>
                <input
                    type="text"
                    id="otp"
                    name="otp"
                    maxlength="6"
                    autofocus
                    required
                    inputmode="numeric"
                    pattern="[0-9]{6}"
                    placeholder="123456"
                    class="input-starline w-full text-center font-mono text-2xl font-bold tracking-[8px] py-3 text-slate-900"
                >
                @error('otp')
                    <p class="text-[11px] text-rose-600 mt-1 font-medium text-center">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full btn-starline-primary text-xs font-bold py-3">
                Verifikasi &amp; Masuk
            </button>
        </form>

        <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
            <a href="{{ route('login') }}" class="font-bold hover:text-slate-900">
                &larr; Ganti surel
            </a>
            <form action="{{ route('auth.otp.send') }}" method="POST">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">
                <button type="submit" class="font-bold text-slate-700 hover:text-slate-900 underline cursor-pointer">
                    Kirim ulang kode
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
