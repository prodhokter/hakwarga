@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center space-y-6">
    <div class="w-16 h-16 rounded-full bg-amber-400 text-slate-950 mx-auto flex items-center justify-center font-extrabold text-2xl font-mono shadow-xs">
        419
    </div>
    <div class="space-y-2">
        <h1 class="text-3xl font-extrabold text-slate-900 dark:text-white font-display">Sesi Telah Kedaluwarsa</h1>
        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 max-w-md mx-auto leading-relaxed">
            Halaman formulir Anda telah berada dalam kondisi diam terlalu lama demi keamanan transaksi. Silakan muat ulang halaman untuk melanjutkan.
        </p>
    </div>
    <div class="pt-2 flex items-center justify-center gap-3">
        <a href="javascript:window.location.reload()" class="btn-starline-primary text-xs font-bold">
            Muat Ulang Halaman
        </a>
    </div>
</div>
@endsection
