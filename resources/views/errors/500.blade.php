@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center space-y-6">
    <div class="w-16 h-16 rounded-full bg-slate-200 text-slate-800 mx-auto flex items-center justify-center font-bold text-2xl font-display">
        500
    </div>
    <div class="space-y-2">
        <h1 class="text-3xl font-extrabold text-slate-900 font-display">Terjadi Kendala Teknis</h1>
        <p class="text-sm text-slate-600 max-w-md mx-auto leading-relaxed">
            Sistem kami sedang mengalami gangguan sementara. Silakan coba beberapa saat lagi atau laporkan jika kendala berlanjut.
        </p>
    </div>
    <div class="pt-4 flex items-center justify-center gap-3">
        <a href="{{ route('home') }}" class="inline-flex items-center justify-center rounded-md bg-teal-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-teal-800 min-h-[44px]">
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
