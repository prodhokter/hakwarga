@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center space-y-4">
    <div class="w-14 h-14 rounded-full bg-slate-900 text-[#e6ff94] mx-auto flex items-center justify-center font-extrabold text-xl font-mono shadow-xs">
        404
    </div>
    <div class="space-y-1">
        <h1 class="text-2xl font-extrabold text-slate-900 font-display">Tidak Ditemukan</h1>
        <p class="text-xs text-slate-500 max-w-sm mx-auto">
            Halaman Tidak Tersedia
        </p>
    </div>
    <div class="pt-2 flex flex-col sm:flex-row items-center justify-center gap-2">
        <a href="{{ route('home') }}" class="btn-starline-primary text-xs font-bold">
            Beranda
        </a>
        <a href="{{ route('tracker.index') }}" class="btn-starline-ghost text-xs">
            Lacak Resi
        </a>
    </div>
</div>
@endsection
