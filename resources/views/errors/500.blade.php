@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center space-y-6">
    <div class="w-16 h-16 rounded-full bg-slate-800 text-white mx-auto flex items-center justify-center font-extrabold text-2xl font-mono shadow-xs">
        500
    </div>
    <div class="space-y-2">
        <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white font-display">Terjadi Kendala Teknis</h1>
        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 max-w-md mx-auto leading-relaxed">
            Sistem kami sedang mengalami gangguan sementara. Silakan coba beberapa saat lagi atau hubungi petugas kami.
        </p>
    </div>
    <div class="pt-2 flex items-center justify-center gap-3">
        <a href="{{ route('home') }}" class="btn-starline-primary text-xs font-bold">
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
