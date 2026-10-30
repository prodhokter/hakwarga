@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
    <div class="bg-white rounded-2xl border-2 border-teal-700/30 p-6 sm:p-10 shadow-sm text-center space-y-6">
        <div class="w-16 h-16 rounded-full bg-emerald-100 text-emerald-800 mx-auto flex items-center justify-center font-bold text-2xl font-display">
            ✓
        </div>

        <div class="space-y-2">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-display">
                Laporan Anda Berhasil Dicatat
            </h1>
            <p class="text-sm text-slate-600 max-w-lg mx-auto">
                Terima kasih atas partisipasi Anda mengawal pemenuhan hak bantuan sosial. Laporan telah masuk ke sistem audit.
            </p>
        </div>

        {{-- Credentials Box --}}
        <div class="bg-slate-50 rounded-xl p-6 border border-slate-200 text-left space-y-4" x-data="{ copiedTicket: false, copiedSecret: false }">
            <div>
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider block">Nomor Tiket Publik</span>
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mt-1">
                    <span class="text-xl sm:text-2xl font-bold font-mono text-slate-900 tracking-tight select-all">
                        {{ $ticketCode }}
                    </span>
                    <button
                        type="button"
                        @click="navigator.clipboard.writeText('{{ $ticketCode }}'); copiedTicket = true; setTimeout(() => copiedTicket = false, 2500)"
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded text-xs font-semibold border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 min-h-[38px] w-fit"
                    >
                        <span x-show="!copiedTicket">Salin Nomor Tiket</span>
                        <span x-show="copiedTicket" x-cloak class="text-emerald-700 font-bold">&check; Berhasil Disalin!</span>
                    </button>
                </div>
            </div>

            <div class="border-t border-slate-200 pt-4">
                <span class="text-xs font-bold text-amber-900 uppercase tracking-wider block">
                    Kode Rahasia Akses Tiket (Hanya Tampil Sekali)
                </span>
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mt-1">
                    <span class="text-xl sm:text-2xl font-bold font-mono text-teal-900 tracking-widest bg-amber-100/60 px-3 py-1.5 rounded border border-amber-300 select-all">
                        {{ $secretCode }}
                    </span>
                    <button
                        type="button"
                        @click="navigator.clipboard.writeText('{{ $secretCode }}'); copiedSecret = true; setTimeout(() => copiedSecret = false, 2500)"
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded text-xs font-bold border border-amber-400 bg-amber-100 hover:bg-amber-200 text-amber-950 min-h-[38px] w-fit"
                    >
                        <span x-show="!copiedSecret">Salin Kode Rahasia</span>
                        <span x-show="copiedSecret" x-cloak class="text-emerald-800 font-bold">&check; Berhasil Disalin!</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Safety Notice --}}
        <div class="rounded-lg bg-amber-50 p-4 border border-amber-200 text-left text-xs text-amber-900 space-y-1.5">
            <p class="font-bold">PENTING: Catat atau Ambil Tangkapan Layar Sekarang</p>
            <p>
                Demi perlindungan anonimitas mutlak Anda, sistem ini tidak menyimpan kode rahasia dalam bentuk teks terbaca. Jika kode ini hilang, isi laporan dan balasan petugas tidak akan dapat dibuka kembali.
            </p>
        </div>

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row gap-3 pt-2">
            <a
                href="{{ route('ticket.show', ['ticket' => $ticketCode]) }}"
                class="flex-1 inline-flex items-center justify-center rounded-md bg-teal-700 px-5 py-3 text-sm font-semibold text-white hover:bg-teal-800 min-h-[44px]"
            >
                Buka &amp; Pantau Tiket Sekarang &rarr;
            </a>
            <a
                href="{{ route('home') }}"
                class="inline-flex items-center justify-center rounded-md bg-slate-100 px-5 py-3 text-sm font-semibold text-slate-700 hover:bg-slate-200 min-h-[44px]"
            >
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
