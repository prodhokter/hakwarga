@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center space-y-4">
    <div class="w-14 h-14 rounded-full bg-rose-500 text-white mx-auto flex items-center justify-center font-extrabold text-xl font-mono shadow-xs">
        429
    </div>
    <div class="space-y-1">
        <h1 class="text-2xl font-extrabold text-slate-900 font-display">Batas Akses</h1>
        <p class="text-xs text-slate-500 max-w-sm mx-auto">
            Tunggu 1 Menit
        </p>
    </div>
    <div class="pt-2 flex items-center justify-center gap-2">
        <a href="{{ route('home') }}" class="btn-starline-primary text-xs font-bold">
            Beranda
        </a>
    </div>
</div>
@endsection
