@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center space-y-6">
    <div class="w-16 h-16 rounded-full bg-rose-500 text-white mx-auto flex items-center justify-center font-extrabold text-2xl font-mono shadow-xs">
        429
    </div>
    <div class="space-y-2">
        <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white font-display">Terlalu Banyak Permintaan</h1>
        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 max-w-md mx-auto leading-relaxed">
            Sistem mendeteksi akses pencarian yang terlalu cepat dari koneksi Anda. Demi menjaga stabilitas layanan warga, silakan tunggu 1 menit sebelum mencoba kembali.
        </p>
    </div>
    <div class="pt-2 flex items-center justify-center gap-3">
        <a href="{{ route('home') }}" class="btn-starline-primary text-xs font-bold">
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
