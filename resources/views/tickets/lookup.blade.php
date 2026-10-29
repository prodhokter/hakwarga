@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
    <div class="text-center space-y-2">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-display">
            Akses &amp; Pantau Tiket Laporan Warga
        </h1>
        <p class="text-sm text-slate-600">
            Masukkan nomor tiket dan kode rahasia 12 karakter yang Anda dapatkan saat mengirimkan laporan.
        </p>
    </div>

    @if($errors->any())
        <div class="bg-rose-50 border border-rose-200 text-rose-900 rounded-lg p-4 text-xs space-y-1">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <div class="bg-white rounded-xl border border-slate-200 p-6 sm:p-8 shadow-xs">
        <form action="{{ route('ticket.access') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label for="lookup-ticket-code" class="block text-sm font-semibold text-slate-900 mb-1">
                    Nomor Tiket Laporan <span class="text-rose-600">*</span>
                </label>
                <input
                    type="text"
                    id="lookup-ticket-code"
                    name="ticket_code"
                    value="{{ old('ticket_code') }}"
                    placeholder="Contoh: HWT-2026-7K3M9Q"
                    required
                    autofocus
                    class="w-full rounded-md border border-slate-300 px-3.5 py-2.5 text-base text-slate-900 placeholder:text-slate-400 focus:border-teal-700 focus:ring-2 focus:ring-teal-700 font-mono uppercase min-h-[44px]"
                >
            </div>

            <div>
                <label for="lookup-secret-code" class="block text-sm font-semibold text-slate-900 mb-1">
                    Kode Rahasia Tiket <span class="text-rose-600">*</span>
                </label>
                <input
                    type="text"
                    id="lookup-secret-code"
                    name="secret_code"
                    placeholder="Contoh: 4HX7-9K2M-P8Q3"
                    required
                    class="w-full rounded-md border border-slate-300 px-3.5 py-2.5 text-base text-slate-900 placeholder:text-slate-400 focus:border-teal-700 focus:ring-2 focus:ring-teal-700 font-mono uppercase min-h-[44px]"
                >
                <p class="text-xs text-slate-500 mt-1">12 karakter huruf dan angka dengan tanda hubung.</p>
            </div>

            <div class="pt-2">
                <button
                    type="submit"
                    class="w-full inline-flex items-center justify-center rounded-md bg-teal-700 px-6 py-3 text-base font-semibold text-white hover:bg-teal-800 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal-900 min-h-[44px]"
                >
                    Buka Rincian &amp; Tindak Lanjut Tiket
                </button>
            </div>
        </form>
    </div>

    {{-- Lost Secret Reassurance --}}
    <div class="bg-slate-100 rounded-lg p-4 border border-slate-200 text-xs text-slate-600 space-y-1">
        <p class="font-semibold text-slate-800">Bagaimana jika kode rahasia hilang?</p>
        <p>
            Demi prinsip privasi zero-knowledge, sistem tidak dapat memulihkan kode rahasia yang hilang. Anda tetap dapat melihat status kemajuan publik tanpa membaca isi aduan, atau mengirimkan laporan baru jika diperlukan.
        </p>
    </div>
</div>
@endsection
