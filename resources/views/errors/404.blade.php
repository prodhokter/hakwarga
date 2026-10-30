@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center space-y-6">
    <div class="w-16 h-16 rounded-full bg-slate-900 text-[#e6ff94] dark:bg-[#e6ff94] dark:text-slate-950 mx-auto flex items-center justify-center font-extrabold text-2xl font-mono shadow-xs">
        404
    </div>
    <div class="space-y-2">
        <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white font-display">Halaman Tidak Ditemukan</h1>
        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 max-w-md mx-auto leading-relaxed">
            Halaman atau tautan yang Anda tuju tidak tersedia atau telah dipindahkan ke alamat lain.
        </p>
    </div>
    <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-3">
        <a href="{{ route('home') }}" class="btn-starline-primary text-xs font-bold">
            Kembali ke Beranda
        </a>
        <a href="{{ route('tracker.index') }}" class="btn-starline-ghost text-xs">
            Lacak Nomor Resi
        </a>
    </div>
</div>
@endsection
