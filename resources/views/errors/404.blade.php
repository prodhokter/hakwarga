@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center space-y-6">
    <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-700 mx-auto flex items-center justify-center font-bold text-2xl font-display">
        404
    </div>
    <div class="space-y-2">
        <h1 class="text-3xl font-extrabold text-slate-900 font-display">Halaman Tidak Ditemukan</h1>
        <p class="text-sm text-slate-600 max-w-md mx-auto leading-relaxed">
            Halaman atau tautan yang Anda tuju tidak tersedia atau telah dipindahkan ke alamat lain.
        </p>
    </div>
    <div class="pt-4 flex flex-col sm:flex-row items-center justify-center gap-3">
        <a href="{{ route('home') }}" class="inline-flex items-center justify-center rounded-md bg-teal-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-teal-800 min-h-[44px]">
            Kembali ke Beranda
        </a>
        <a href="{{ route('tracker.index') }}" class="inline-flex items-center justify-center rounded-md bg-white border border-slate-300 px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50 min-h-[44px]">
            Lacak Nomor Resi
        </a>
    </div>
</div>
@endsection
