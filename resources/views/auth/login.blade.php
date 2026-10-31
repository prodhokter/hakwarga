@extends('layouts.app', ['title' => 'Masuk Akun'])

@section('content')
<div class="max-w-md mx-auto px-4 py-12 sm:py-16">
    <div class="starline-card p-6 sm:p-8 bg-white/95 backdrop-blur-xl border border-slate-200/90 shadow-sm rounded-3xl">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-[#0f172a] text-[#e6ff94] mb-3 shadow-xs">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <h1 class="text-2xl font-extrabold text-slate-900 font-display tracking-tight">Masuk Akun</h1>
            <p class="text-xs text-slate-500 mt-1 font-sans">Pilih metode masuk untuk mengelola riwayat dan tiket</p>
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

        <div class="space-y-4">
            {{-- 1. Google OAuth Button --}}
            <a href="{{ route('auth.google') }}"
               class="w-full flex items-center justify-center gap-3 px-4 py-3 rounded-2xl border border-slate-200 bg-white hover:bg-slate-50 text-slate-800 text-xs font-bold transition-all shadow-2xs hover:border-slate-300">
                <svg class="w-4 h-4 shrink-0" viewBox="0 0 24 24">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                </svg>
                Masuk dengan Akun Google
            </a>

            <div class="relative flex items-center justify-center my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-slate-200"></div>
                </div>
                <span class="relative px-3 bg-white text-[11px] font-mono text-slate-400 uppercase tracking-wider">Atau via Surel OTP</span>
            </div>

            {{-- 2. Email OTP Form --}}
            <form action="{{ route('auth.otp.send') }}" method="POST" class="space-y-3">
                @csrf
                <div>
                    <label for="email" class="block text-xs font-bold text-slate-700 mb-1">Alamat Surel</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="nama@domain.com"
                        required
                        class="input-starline w-full text-xs font-medium"
                    >
                    @error('email')
                        <p class="text-[11px] text-rose-600 mt-1 font-medium">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full btn-starline-primary text-xs font-bold py-3">
                    Kirim Kode OTP
                </button>
            </form>

            <div class="pt-4 border-t border-slate-100 text-center">
                <p class="text-[11px] text-slate-500 mb-2">Tidak ingin mendaftar sekarang?</p>
                {{-- 3. Guest Mode Button --}}
                <a href="{{ route('auth.guest') }}"
                   class="inline-flex items-center justify-center gap-2 px-4 py-2 rounded-xl text-xs font-bold text-slate-700 bg-slate-100 hover:bg-slate-200 transition-colors">
                    <svg class="w-4 h-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Jelajah sebagai Tamu
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
