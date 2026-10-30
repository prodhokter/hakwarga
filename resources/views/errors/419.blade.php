@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center space-y-6">
    <div class="w-16 h-16 rounded-full bg-amber-100 text-amber-800 mx-auto flex items-center justify-center font-bold text-2xl font-display">
        419
    </div>
    <div class="space-y-2">
        <h1 class="text-3xl font-extrabold text-slate-900 font-display">Sesi Telah Kedaluwarsa</h1>
        <p class="text-sm text-slate-600 max-w-md mx-auto leading-relaxed">
            Halaman formulir Anda telah berada dalam kondisi diam terlalu lama demi keamanan transaksi. Silakan muat ulang halaman untuk melanjutkan.
        </p>
    </div>
    <div class="pt-4 flex items-center justify-center gap-3">
        <a href="javascript:window.location.reload()" class="inline-flex items-center justify-center rounded-md bg-teal-700 px-5 py-2.5 text-sm font-semibold text-white hover:bg-teal-800 min-h-[44px]">
            Muat Ulang Halaman
        </a>
    </div>
</div>
@endsection
