@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8 py-12 space-y-8">
    <div class="starline-card p-6 sm:p-10 text-center space-y-6 rounded-2xl shadow-sm">
        <div class="w-14 h-14 rounded-full bg-[#e6ff94] text-slate-950 mx-auto flex items-center justify-center font-extrabold text-2xl font-mono shadow-xs">
            &check;
        </div>

        <div class="space-y-1.5">
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white font-display">
                Laporan Anda Berhasil Dicatat
            </h1>
            <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 max-w-lg mx-auto">
                Terima kasih atas partisipasi Anda mengawal transparansi bansos. Laporan telah masuk ke antrean verifikasi petugas.
            </p>
        </div>

        {{-- Credentials Box --}}
        <div class="bg-white/80 dark:bg-slate-900/80 rounded-xl p-6 border border-slate-200/80 dark:border-slate-800 text-left space-y-4" x-data="{ copiedTicket: false, copiedSecret: false }">
            <div>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider block">Nomor Tiket Publik</span>
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mt-1">
                    <span class="text-xl sm:text-2xl font-bold font-mono text-slate-900 dark:text-white tracking-tight select-all">
                        {{ $ticketCode }}
                    </span>
                    <button
                        type="button"
                        @click="navigator.clipboard.writeText('{{ $ticketCode }}'); copiedTicket = true; window.hwToast('Nomor tiket disalin!'); setTimeout(() => copiedTicket = false, 2500)"
                        class="btn-starline-ghost text-xs cursor-pointer w-fit"
                    >
                        <span x-show="!copiedTicket">Salin Nomor Tiket</span>
                        <span x-show="copiedTicket" x-cloak class="text-emerald-700 dark:text-emerald-400 font-bold">&check; Tersalin!</span>
                    </button>
                </div>
            </div>

            <div class="border-t border-slate-200/60 dark:border-slate-800 pt-4">
                <span class="text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider block">
                    Kode Rahasia Akses Tiket (Hanya Tampil Sekali)
                </span>
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 mt-1">
                    <span class="text-xl sm:text-2xl font-bold font-mono text-slate-950 dark:text-slate-900 tracking-widest bg-[#e6ff94] px-3.5 py-1.5 rounded-lg border border-[#c2e050] select-all shadow-2xs">
                        {{ $secretCode }}
                    </span>
                    <button
                        type="button"
                        @click="navigator.clipboard.writeText('{{ $secretCode }}'); copiedSecret = true; window.hwToast('Kode rahasia disalin!'); setTimeout(() => copiedSecret = false, 2500)"
                        class="btn-starline-primary text-xs cursor-pointer w-fit"
                    >
                        <span x-show="!copiedSecret">Salin Kode Rahasia</span>
                        <span x-show="copiedSecret" x-cloak class="text-slate-950 font-bold">&check; Tersalin!</span>
                    </button>
                </div>
            </div>
        </div>

        {{-- Safety Notice --}}
        <div class="rounded-xl bg-amber-50 dark:bg-amber-950/60 p-4 border border-amber-200 dark:border-amber-800 text-left text-xs text-amber-900 dark:text-amber-200 space-y-1.5">
            <p class="font-bold">PENTING: Catat atau Simpan Kode Rahasia Sekarang</p>
            <p>
                Demi perlindungan anonimitas mutlak Anda, sistem tidak menyimpan kode rahasia dalam bentuk teks terbaca. Jika kode ini hilang, isi laporan dan balasan petugas tidak akan dapat dibuka kembali.
            </p>
        </div>

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row gap-3 pt-2">
            <a
                href="{{ route('ticket.show', ['ticket' => $ticketCode]) }}"
                class="btn-starline-primary flex-1 text-xs font-bold"
            >
                Buka &amp; Pantau Tiket Sekarang &rarr;
            </a>
            <a
                href="{{ route('home') }}"
                class="btn-starline-ghost text-xs"
            >
                Kembali ke Beranda
            </a>
        </div>
    </div>
</div>
@endsection
