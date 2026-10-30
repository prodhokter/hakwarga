@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center space-y-4">
    <div class="w-14 h-14 rounded-full bg-amber-400 text-slate-950 mx-auto flex items-center justify-center font-extrabold text-xl font-mono shadow-xs">
        419
    </div>
    <div class="space-y-1">
        <h1 class="text-2xl font-extrabold text-slate-900 font-display">Sesi Kedaluwarsa</h1>
        <p class="text-xs text-slate-500 max-w-sm mx-auto">
            Muat Ulang Halaman
        </p>
    </div>
    <div class="pt-2 flex items-center justify-center gap-2">
        <a href="javascript:window.location.reload()" class="btn-starline-primary text-xs font-bold">
            Muat Ulang
        </a>
    </div>
</div>
@endsection
